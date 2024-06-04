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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->default(0);
            $table->integer('post_id')->default(0);
            $table->string('name', 500);
            $table->string('image', 500)->nullable();
            $table->text('content')->nullable();
            $table->integer('views')->default(0);
            $table->integer('fav')->default(0);
            $table->boolean('inactive')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
