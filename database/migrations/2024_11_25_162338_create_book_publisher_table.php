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
        Schema::create('book_publisher', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id')->unique();
            $table->unsignedBigInteger('publisher_id');
            $table->timestamps();

            $table->foreign('book_id')->references('id')->on('book')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('publisher_id')->references('id')->on('publisher')->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_publisher');
    }
};