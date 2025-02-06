<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementCategoryAnnouncementTable extends Migration
{
    public function up()
    {
        Schema::create('announcement_category_announcement', function (Blueprint $table) {
            $table->id(); // auto-incrementing ID column for the pivot table
            $table->foreignId('announcement_id')->constrained()->onDelete('cascade');
            $table->foreignId('announcement_category_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // to track when the record was created/updated
        });
    }

    public function down()
    {
        Schema::dropIfExists('announcement_category_announcement');
    }
}
