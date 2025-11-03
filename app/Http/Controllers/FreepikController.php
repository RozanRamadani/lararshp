<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class FreepikController extends Controller
{
    /**
     * Proxy a Freepik search request and return the preferred image (svg/png).
     * Query param: query (string)
     *
     * NOTE: Freepik integrations vary; set `FREEPIK_API_KEY` and `FREEPIK_SEARCH_ENDPOINT` in .env.
     */
    public function proxy(Request $request)
    {
        $q = $request->query('query');
        if (empty($q)) {
            return response('Missing query', 400);
        }

        $apiKey = config('freepik.api_key');
        if (empty($apiKey)) {
            return response('Freepik API key not configured', 500);
        }

        $searchUrl = config('freepik.search_endpoint');
        if (empty($searchUrl)) {
            return response('Freepik search endpoint not configured', 500);
        }

        try {
            // Cache key so repeated icon requests don't hit the API every time.
            $cacheKey = 'freepik:icon:' . md5($q);
            $cached = Cache::get($cacheKey);
            if ($cached && is_array($cached) && !empty($cached['body'])) {
                return response($cached['body'], 200)->header('Content-Type', $cached['content_type'] ?? 'image/svg+xml');
            }

            // Attempt a generic search request. The exact parameters depend on the Freepik integration.
            // We include both `query` and `q` to increase compatibility with different provider endpoints.
            $resp = Http::withToken($apiKey)
                ->accept('application/json')
                ->get($searchUrl, ['query' => $q, 'q' => $q, 'limit' => 1]);

            if (!$resp->successful()) {
                Log::warning('Freepik search failed', ['status' => $resp->status(), 'body' => $resp->body()]);
                return response('Icon not found', 404);
            }

            $data = $resp->json();
            $imgUrl = null;

            // Try several common result shapes to extract an image URL
            if (!empty($data['data'][0])) {
                $item = $data['data'][0];
            } elseif (!empty($data['results'][0])) {
                $item = $data['results'][0];
            } elseif (!empty($data[0])) {
                $item = $data[0];
            } else {
                $item = null;
            }

            if ($item) {
                if (!empty($item['image_svg'])) {
                    $imgUrl = $item['image_svg'];
                } elseif (!empty($item['images']['svg'])) {
                    $imgUrl = $item['images']['svg'][0]['url'] ?? null;
                } elseif (!empty($item['images']['png'])) {
                    $imgUrl = $item['images']['png'][0]['url'] ?? null;
                } elseif (!empty($item['image'])) {
                    $imgUrl = $item['image'];
                } elseif (!empty($item['preview_url'])) {
                    $imgUrl = $item['preview_url'];
                }
            }

            if (!$imgUrl) {
                return response('No image available from Freepik result', 404);
            }

            // Fetch the image content. Some providers require the API token to fetch the image; try without token first.
            $imageResp = Http::get($imgUrl);
            if (!$imageResp->successful()) {
                // Retry with token in case the image endpoint requires authorization
                $imageResp = Http::withToken($apiKey)->get($imgUrl);
                if (!$imageResp->successful()) {
                    Log::warning('Freepik fetch failed', ['status' => $imageResp->status(), 'url' => $imgUrl]);
                    return response('Unable to fetch icon image', 502);
                }
            }

            $contentType = $imageResp->header('Content-Type', 'image/svg+xml');
            $body = $imageResp->body();

            // Cache image bytes for 7 days (adjust as needed)
            Cache::put($cacheKey, ['body' => $body, 'content_type' => $contentType], now()->addDays(7));

            return response($body, 200)->header('Content-Type', $contentType);
        } catch (\Exception $e) {
            Log::error('Freepik proxy error: '.$e->getMessage());
            return response('Internal error', 500);
        }
    }
}
