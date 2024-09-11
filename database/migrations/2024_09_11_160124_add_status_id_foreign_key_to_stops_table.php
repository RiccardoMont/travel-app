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
        Schema::table('stops', function (Blueprint $table) {
            
            $table->unsignedBigInteger('status_id')->nullable();

            $table->foreign('status_id')
            ->references('id')
            ->on('statuses')
            ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stops', function (Blueprint $table) {
            
            $table->dropForeign('stops_status_id_foreign');

            $table->dropColumn('status_id');
        });
    }
};
