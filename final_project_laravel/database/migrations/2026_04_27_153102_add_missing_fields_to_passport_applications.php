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
            $table->date('date_of_birth')->nullable()->after('full_name');
            $table->string('mother_name')->nullable()->after('date_of_birth');
            $table->enum('gender', ['male', 'female'])->nullable()->after('mother_name');
            $table->text('address')->nullable()->after('gender');
            $table->foreignId('pickup_branch_id')->nullable()->after('branch_id')->constrained('branches')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('passport_applications', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pickup_branch_id');
            $table->dropColumn(['date_of_birth', 'mother_name', 'gender', 'address']);
        });
    }
};
