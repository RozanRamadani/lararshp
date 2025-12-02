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
        Schema::table('pet', function (Blueprint $table) {
            if (!Schema::hasColumn('pet', 'deleted_at')) {
                $table->softDeletes();
            }
            if (!Schema::hasColumn('pet', 'deleted_by')) {
                $table->unsignedBigInteger('deleted_by')->nullable()->after('deleted_at');
            }
            if (!Schema::hasColumn('pet', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pet', function (Blueprint $table) {
            if (Schema::hasColumn('pet', 'deleted_by')) {
                $table->dropColumn('deleted_by');
            }
            if (Schema::hasColumn('pet', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
            if (Schema::hasColumn('pet', 'created_at')) {
                $table->dropTimestamps();
            }
        });
    }
};
