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
       Schema::create('attendances', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('student_id');
    $table->unsignedBigInteger('class_id');
    $table->unsignedBigInteger('section_id');
    $table->unsignedBigInteger('subject_id');
    $table->unsignedBigInteger('teacher_id');
    $table->date('date');
    $table->enum('status', ['present', 'absent', 'leave']);
    $table->timestamps();

    // Foreign keys (optional for constraint)
    $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
    $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
    $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
    $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
    $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
