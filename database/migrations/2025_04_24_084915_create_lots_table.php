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
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image')->nullable();
            $table->string('type')->nullable();
            $table->integer('size')->nullable();
            $table->string('area')->nullable();
            $table->string('marker')->nullable();
            $table->integer('slots')->nullable();
            $table->integer('price')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('owner_id');

            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
