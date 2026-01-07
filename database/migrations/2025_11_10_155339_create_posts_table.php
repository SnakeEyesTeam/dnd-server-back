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
            $table->string("content", 255);
            $table->string("tags")->nullable();
            $table->string("files")->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('departament_id');
            $table->unsignedBigInteger('like_id')->nullable();
            $table->unsignedBigInteger('view_id')->nullable();
            $table->timestamps();

            $table->foreign('departament_id')->references('id')->on('departaments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('like_id')->references('id')->on('likes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('view_id')->references('id')->on('views')->onDelete('cascade')->onUpdate('cascade');
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
