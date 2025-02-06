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
        Schema::create('knwoledgebases', function (Blueprint $table) {
            $table->unsignedBigInteger('published');
            $table->id();$table->string('title');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('publisher_id');
            $table->date('date_knwoledgebase');
            $table->longText('description');
            $table->string('url_link');
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
        Schema::dropIfExists('knwoledgebases');
    }
};
