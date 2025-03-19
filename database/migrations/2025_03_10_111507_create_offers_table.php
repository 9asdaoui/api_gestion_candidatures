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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('company_name');
            $table->string('location');
            $table->decimal('salary', 10, 2)->nullable();
            $table->enum('employment_type', ['Full-time', 'Part-time', 'Contract', 'Freelance', 'Internship']); 
            $table->enum('experience_level', ['Entry-level', 'Mid-level', 'Senior', 'Manager', 'Executive'])->nullable();
            $table->json('required_skills')->nullable();
            $table->date('deadline')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
