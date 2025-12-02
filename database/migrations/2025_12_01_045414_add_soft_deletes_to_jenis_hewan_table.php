<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jenis_hewan', function (Blueprint $table) {
            if (!Schema::hasColumn('jenis_hewan', 'deleted_at')) {
                $table->softDeletes();
            }
            if (!Schema::hasColumn('jenis_hewan', 'deleted_by')) {
                $table->unsignedBigInteger('deleted_by')->nullable()->after('deleted_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenis_hewan', function (Blueprint $table) {
            if (Schema::hasColumn('jenis_hewan', 'deleted_by')) {
                $table->dropForeign(['deleted_by']);
                $table->dropColumn('deleted_by');
            }
            if (Schema::hasColumn('jenis_hewan', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
