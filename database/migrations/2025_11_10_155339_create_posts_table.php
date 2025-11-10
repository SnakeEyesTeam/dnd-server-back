<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string("title", 52);
            $table->string("description",255);
            $table->unsignedBigInteger('Uid');
            $table->unsignedBigInteger('Did');
            $table->timestamps();

            $table->foreign('Did')->references('id')->on('deportaments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Uid')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
