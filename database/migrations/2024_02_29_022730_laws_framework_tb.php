<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laws_framework_tb', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('publisher_id');
            $table->longText('description');
            $table->date('date_published');
            $table->string('url_link');
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
            $table->index('title');
        });
    }

    public function down():  void
    {
        Schema::dropIfExists('laws_framework_tb');
    }
};
