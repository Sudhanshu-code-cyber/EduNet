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
       Schema::create('exam_schedules', function (Blueprint $table) {
    $table->id();
    $table->string('exam_name');
    $table->unsignedBigInteger('class_id');
    $table->unsignedBigInteger('section_id');
    $table->unsignedBigInteger('subject_id');
    $table->date('exam_date');
    $table->time('start_time');
    $table->time('end_time');
    $table->integer('duration'); // in minutes
    $table->string('room_no');
    $table->integer('max_marks');
    $table->integer('min_marks');
    $table->unsignedBigInteger('teacher_id');
    $table->timestamps();

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
        Schema::dropIfExists('exam_schedules');
    }
};
