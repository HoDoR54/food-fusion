<?php

use App\Enums\ContactFormSubmissionType;
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
        Schema::create('contact_form_submissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('subject');
            $table->enum('type', ContactFormSubmissionType::values())->default(ContactFormSubmissionType::General->value);
            $table->text('message');
            $table->boolean('is_anonymous')->default(false);
            $table->uuid('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_form_submissions');
    }
};
