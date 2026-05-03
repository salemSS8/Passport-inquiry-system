<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();

        if ($branches->isEmpty()) {
            $this->command->warn('لا توجد فروع! قم بتشغيل BranchSeeder أولاً.');

            return;
        }

        $employeeNames = [
            'أحمد محمد العامري',
            'خالد عبدالله السعيدي',
            'محمد صالح الحارثي',
            'عبدالرحمن علي المقبلي',
            'سالم حسين باعبيد',
            'فهد ناصر الشريف',
            'يوسف إبراهيم الزبيدي',
            'عمر حسن الأهدل',
            'طارق عبدالكريم النعمان',
            'بلال أحمد الكثيري',
            'ماجد سعيد الجابري',
            'هاني محمود الحميدي',
            'وليد عادل البريهي',
            'رامي فيصل الشرجبي',
            'نبيل عبدالوهاب الأغبري',
            'ياسر جمال الصنعاني',
            'زياد مراد التميمي',
            'حاتم رشاد المخلافي',
            'سامي توفيق الوصابي',
            'أنس كمال السقاف',
        ];

        $index = 0;

        foreach ($branches as $branch) {
            // Create 2 employees per branch
            for ($i = 0; $i < 2; $i++) {
                $name = $employeeNames[$index % count($employeeNames)];
                $emailSlug = 'emp'.($index + 1);

                User::updateOrCreate(
                    ['email' => $emailSlug.'@passport.gov.ye'],
                    [
                        'name' => $name,
                        'password' => Hash::make('password'),
                        'role' => User::ROLE_EMPLOYEE,
                        'branch_id' => $branch->id,
                        'email_verified_at' => now(),
                    ]
                );

                $index++;
            }
        }
    }
}
