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
            Schema::table('teachers', function (Blueprint $table) {
        $table->dropColumn(['class', 'section']); 
        $table->string('qualification')->nullable()->after('email'); 
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('teachers', function (Blueprint $table) {
        $table->string('class')->nullable();
        $table->string('section')->nullable();
        $table->dropColumn('qualification');
    });
    }
};
