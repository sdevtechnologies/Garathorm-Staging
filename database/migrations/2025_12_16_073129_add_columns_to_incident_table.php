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
        Schema::table('incident_announcements', function (Blueprint $table) {
            $table->boolean('website')->default(false);
            $table->boolean('criticality')->default(false);
            $table->boolean('report')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incident_announcements', function (Blueprint $table) {
            $table->dropColumn('website');
            $table->dropColumn('criticality');
            $table->dropColumn('report');
        });
    }
};
