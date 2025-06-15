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
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
             $table->string('route_name');
            $table->string('pickup_time')->nullable(); // E.g., "08:00 AM - 05:30 PM"
            $table->string('drop_time')->nullable(); // E.g., "08:00 AM - 05:30 PM"
            $table->string('vehicle_number');
            $table->string('vehicle_capacity')->nullable(); // E.g., "50 km"
            $table->string('driver_name');
            $table->string('license_number');
            $table->string('phone_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
