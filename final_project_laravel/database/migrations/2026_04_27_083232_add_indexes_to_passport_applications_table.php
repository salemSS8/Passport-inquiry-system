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
            $table->index('national_id');
            $table->index('tracking_number');
            $table->index(['national_id', 'tracking_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('passport_applications', function (Blueprint $table) {
            $table->dropIndex(['national_id']);
            $table->dropIndex(['tracking_number']);
            $table->dropIndex(['national_id', 'tracking_number']);
        });
    }
};
