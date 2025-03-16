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
            $table->string('content_type')->nullable()->after('url');
            $table->string('video_id')->nullable()->after('content_type');
            $table->string('video_url')->nullable()->after('video_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipe_images', function (Blueprint $table) {
            $table->dropColumn(['content_type', 'video_id', 'video_url']);
        });
    }
};
