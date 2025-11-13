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
        Schema::create('bans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Uid');
            $table->string('Desc');
            $table->unsignedBigInteger('Aid');
            $table->timestamp('ban_time')->useCurrent();
            $table->timestamp('unban_time')->nullable();

            $table->foreign('Aid')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Uid')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bans');
    }
};
