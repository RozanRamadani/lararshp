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
        Schema::table('kode_tindakan_terapi', function (Blueprint $table) {
            if (!Schema::hasColumn('kode_tindakan_terapi', 'deleted_at')) {
                $table->softDeletes();
            }
            if (!Schema::hasColumn('kode_tindakan_terapi', 'deleted_by')) {
                $table->unsignedBigInteger('deleted_by')->nullable()->after('deleted_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kode_tindakan_terapi', function (Blueprint $table) {
            if (Schema::hasColumn('kode_tindakan_terapi', 'deleted_by')) {
                $table->dropForeign(['deleted_by']);
                $table->dropColumn('deleted_by');
            }
            if (Schema::hasColumn('kode_tindakan_terapi', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
