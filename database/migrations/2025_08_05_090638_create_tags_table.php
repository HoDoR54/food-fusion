<?php

use App\Enums\TagType;
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
        Schema::create('tags', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->enum('type', TagType::values())->default(TagType::Origin->value);
            $table->timestamps();
        });

        Schema::create('recipes_tags_joint', function (Blueprint $table) {
            $table->uuid('recipe_id');
            $table->uuid('tag_id');
            $table->timestamps();

            $table->primary(['recipe_id', 'tag_id']);
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');        
        Schema::dropIfExists('recipes_tags_joint');
    }
};
