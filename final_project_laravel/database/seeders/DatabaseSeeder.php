<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\PassportApplication;
use App\Models\StatusUpdate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::factory()->create([
            'name' => 'System Admin',
            'email' => 'admin@passport.gov',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
        ]);

        // Create Branches
        $branches = Branch::factory(5)->create();

        // Create Employees
        foreach ($branches as $branch) {
            User::factory(3)->create([
                'role' => User::ROLE_EMPLOYEE,
                'branch_id' => $branch->id,
            ]);
        }

        // Create Passport Applications (50+)
        $applications = PassportApplication::factory(60)->recycle($branches)->create();

        // Create Status Updates for each application
        foreach ($applications as $application) {
            StatusUpdate::factory(rand(1, 3))->create([
                'passport_application_id' => $application->id,
                'updated_by' => $admin->id,
            ]);
        }
    }
}
