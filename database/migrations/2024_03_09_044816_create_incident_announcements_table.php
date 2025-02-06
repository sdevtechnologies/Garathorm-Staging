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
        Schema::create('incident_announcements', function (Blueprint $table) {
            $table->id();$table->string('title');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('publisher_id');
            $table->longText('description');
            $table->date('date_incident');
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
        Schema::dropIfExists('incident_announcements');
    }
};
