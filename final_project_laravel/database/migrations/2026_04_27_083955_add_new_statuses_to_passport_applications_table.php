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
        Schema::table('passport_applications', function (Blueprint $table) {
            $table->enum('status', ['pending', 'processing', 'ready', 'collected', 'cancelled', 'archived'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('passport_applications', function (Blueprint $table) {
            $table->enum('status', ['pending', 'processing', 'ready', 'collected'])->default('pending')->change();
        });
    }
};
