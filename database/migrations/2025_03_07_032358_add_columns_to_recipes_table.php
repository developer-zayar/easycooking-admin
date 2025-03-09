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
        Schema::table('recipes', function (Blueprint $table) {
            // Add slug column without unique constraint first
            $table->string('slug')->nullable()->after('id');
        });

        // Update existing records with a temporary slug
        DB::table('recipes')->update(['slug' => DB::raw("CONCAT('recipe-', id)")]);

        Schema::table('recipes', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable(false)->change();
            $table->text('instructions')->nullable()->after('description');
            $table->integer('prep_time')->unsigned()->nullable()->after('instructions');
            $table->integer('cook_time')->unsigned()->nullable()->after('prep_time');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->after('cook_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn(['slug', 'instructions', 'prep_time', 'cook_time', 'status']);
        });
    }
};
