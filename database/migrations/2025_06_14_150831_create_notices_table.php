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
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
    $table->text('details');
    $table->date('date'); // Post date
    $table->timestamp('expires_at')->nullable(); // Expiration support
    $table->unsignedBigInteger('created_by'); // User ID
    $table->enum('creator_role', ['admin', 'teacher']);
    $table->enum('target', ['teacher', 'student']); // Who it's for
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
