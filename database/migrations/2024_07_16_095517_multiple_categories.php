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
        //
        Schema::create('law_category_laws_framework_tb', function (Blueprint $table) {
            $table->unsignedBigInteger('laws_framework_tb_id');
            $table->unsignedBigInteger('law_category_id');
        });
        Schema::create('industry_category_industry_reference', function (Blueprint $table) {
            $table->unsignedBigInteger('industry_reference_id');
            $table->unsignedBigInteger('industry_category_id');
            $table->index('industry_reference_id');
            $table->index('industry_category_id');
        });
        Schema::create('incident_category_incident_announcement', function (Blueprint $table) {
            $table->unsignedBigInteger('incident_announcement_id');
            $table->unsignedBigInteger('incident_category_id');
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('law_category_laws_framework_tb');
        
        Schema::dropIfExists('industry_category_industry_reference');
        
        Schema::dropIfExists('incident_category_incident_announcement');
    }
};
