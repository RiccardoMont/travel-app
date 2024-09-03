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
        Schema::create('stops', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->smallInteger('rating')->nullable();
            $table->decimal('lat', total: 8, places:5)->nullable();
            $table->decimal('lng', total: 8, places:5)->nullable();
            $table->timestamp('date_and_hour')->nullable();
            $table->boolean('checked')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stops');
    }
};
