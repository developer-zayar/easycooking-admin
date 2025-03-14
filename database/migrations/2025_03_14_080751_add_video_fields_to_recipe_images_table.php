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
        Schema::table('recipe_images', function (Blueprint $table) {
            $table->string('contentType')->nullable()->after('url');
            $table->string('videoId')->nullable()->after('contentType');
            $table->string('videoUrl')->nullable()->after('videoId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipe_images', function (Blueprint $table) {
            $table->dropColumn(['contentType', 'videoId', 'videoUrl']);
        });
    }
};
