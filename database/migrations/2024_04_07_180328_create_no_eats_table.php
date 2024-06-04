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
        Schema::create('no_eats', function (Blueprint $table) {
            $table->id();
            $table->string('item1');
            $table->string('item2');
            $table->string('item1image', 500)->nullable();
            $table->string('item2image', 500)->nullable();
            $table->string('action');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('no_eats');
    }
};
