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
        Schema::table('posts', function (Blueprint $table) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('slug')->unique()->after('title');
                $table->json('tags')->nullable()->after('slug');
                $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->after('tags');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn(['slug', 'tags', 'status']);
            });
        });
    }
};
