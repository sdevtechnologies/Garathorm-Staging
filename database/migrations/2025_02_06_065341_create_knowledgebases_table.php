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
        Schema::create('knowledgebases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('category_id');
            $table->longText('description');
            $table->string('url_link');
            $table->boolean('mandatory');
            $table->longText('image')->nullable();
            $table->boolean('status')->default('0');
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();

            $table->index('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledgebases');
    }
};
