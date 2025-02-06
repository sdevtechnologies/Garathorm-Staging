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
        Schema::table('laws_framework_tb', function (Blueprint $table) {
            //$table->dropColumn('category_id');
            $table->boolean('published')->default(true);
        });

        Schema::table('industry_references', function (Blueprint $table) {
            //$table->dropColumn('category_id');
            $table->boolean('published')->default(true);
        });

        Schema::table('incident_announcements', function (Blueprint $table) {
            //$table->dropColumn('category_id');
            $table->boolean('published')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        Schema::table('laws_framework_tb', function (Blueprint $table) {
        
            $table->unsignedBigInteger('category_id');
            $table->dropColumn('published');
        });

        Schema::table('industry_references', function (Blueprint $table) {
        
            $table->unsignedBigInteger('category_id');
            $table->dropColumn('published');
        });
        Schema::table('incident_announcements', function (Blueprint $table) {
        
            $table->unsignedBigInteger('category_id');
            $table->dropColumn('published');
        });
        */
    }
};
