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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');


            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->date('dob')->nullable();
            $table->string('id_no')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('religion')->nullable();
            $table->string('email')->unique();
            $table->string('class')->nullable();   
            $table->string('section')->nullable(); 
            $table->string('phone');
            $table->string('photo')->nullable();   
            $table->text('address');
            $table->text('short_bio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
