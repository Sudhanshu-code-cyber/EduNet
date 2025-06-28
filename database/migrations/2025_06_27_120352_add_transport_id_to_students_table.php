<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('transport_id')->nullable()->after('id'); // Adjust 'after' position as needed
            $table->foreign('transport_id')->references('id')->on('transports')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['transport_id']);
            $table->dropColumn('transport_id');
        });
    }
};
