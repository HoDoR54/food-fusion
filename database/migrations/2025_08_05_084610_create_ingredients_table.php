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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('recipe_ingredient', function (Blueprint $table) {
            $table->uuid('recipe_id');
            $table->uuid('ingredient_id');

            $table->primary(['recipe_id', 'ingredient_id']);
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_ingredient');
        Schema::dropIfExists('ingredients');
    }
};
