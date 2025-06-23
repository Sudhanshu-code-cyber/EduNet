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
        Schema::create('homework', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
$table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
$table->foreignId('section_id')->constrained()->onDelete('cascade');
$table->foreignId('subject_id')->constrained()->onDelete('cascade');
$table->string('title');
$table->text('content');
$table->string('document')->nullable();
$table->date('homework_date');
$table->date('submission_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homework');
    }
};
