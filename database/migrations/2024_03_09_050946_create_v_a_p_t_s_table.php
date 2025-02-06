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
        Schema::create('v_a_p_t_s', function (Blueprint $table) {
            $table->id();$table->string('title');
            $table->string('category');
            $table->longText('description')->nullable();
            $table->date('date_issue');
            $table->string('url_link')->nullable();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();

            $table->index('title');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_a_p_t_s');
    }
};
