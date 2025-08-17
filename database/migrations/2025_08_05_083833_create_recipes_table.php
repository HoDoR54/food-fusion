<?php

use App\Enums\DifficultyLevel;
use App\Enums\RecipePostStatus;
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
        Schema::create('recipes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('posted_by');
            $table->string('name');
            $table->text('description');
            $table->json('steps');
            $table->enum('difficulty', DifficultyLevel::values());
            $table->enum('status', RecipePostStatus::values())->default(RecipePostStatus::PENDING);
            $table->uuid('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('servings')->nullable();
            $table->timestamps();

            $table->foreign('posted_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
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
