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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('section_id')->nullable();
            $table->boolean('uses_transport')->default(false);        
            $table->string('gender');
            $table->date('dob');
            $table->string('roll_no')->unique();
            $table->string('admission_no')->unique();
            $table->string('age');
            $table->string('blood_group')->nullable();
            $table->string('religion')->nullable();
            $table->string('email')->unique();
            $table->string('photo')->nullable(); // only once
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('father_occupation')->nullable();
            $table->string('contact');
            $table->string('nationality');
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('parents_photo')->nullable();
            $table->timestamps();


            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
