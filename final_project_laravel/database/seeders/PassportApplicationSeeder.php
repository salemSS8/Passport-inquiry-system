<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\PassportApplication;
use App\Models\StatusUpdate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PassportApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $branches = Branch::all();

        if ($branches->isEmpty() || ! $admin) {
            $this->command->warn('لا توجد فروع أو مسؤول! قم بتشغيل AdminSeeder و BranchSeeder أولاً.');

            return;
        }

        $applicants = [
            ['name' => 'عبدالله أحمد الشامي',       'mother' => 'فاطمة علي',       'gender' => 'male'],
            ['name' => 'سارة محمد الحمادي',         'mother' => 'أمينة حسن',       'gender' => 'female'],
            ['name' => 'ياسين عمر باسندوة',         'mother' => 'خديجة سالم',      'gender' => 'male'],
            ['name' => 'نورة خالد العيدروس',        'mother' => 'هند محمود',       'gender' => 'female'],
            ['name' => 'محمد علي المنصور',          'mother' => 'سعاد عبدالله',     'gender' => 'male'],
            ['name' => 'أمل صالح الجبلي',          'mother' => 'زهرة أحمد',       'gender' => 'female'],
            ['name' => 'عمار حسين الأنسي',          'mother' => 'نجلاء عمر',       'gender' => 'male'],
            ['name' => 'ريم فاروق العولقي',         'mother' => 'ابتسام يحيى',     'gender' => 'female'],
            ['name' => 'فيصل ناصر الذبحاني',        'mother' => 'مريم صالح',       'gender' => 'male'],
            ['name' => 'هدى إبراهيم النهاري',       'mother' => 'وفاء خالد',       'gender' => 'female'],
            ['name' => 'بدر عبدالرحمن الكبسي',      'mother' => 'حليمة ناصر',      'gender' => 'male'],
            ['name' => 'لينا سعيد باحارثة',         'mother' => 'سميرة فؤاد',      'gender' => 'female'],
            ['name' => 'حسام مراد الحيمي',          'mother' => 'رقية علي',        'gender' => 'male'],
            ['name' => 'دينا عادل الصوفي',          'mother' => 'ليلى حسين',       'gender' => 'female'],
            ['name' => 'رائد جمال الوادعي',         'mother' => 'عائشة سعد',       'gender' => 'male'],
            ['name' => 'سمر توفيق العتمي',          'mother' => 'نبيلة طه',        'gender' => 'female'],
            ['name' => 'زكريا حمدي الأكوع',         'mother' => 'بشرى محمد',       'gender' => 'male'],
            ['name' => 'إيمان رشاد بامخرمة',        'mother' => 'صفية أحمد',       'gender' => 'female'],
            ['name' => 'أسامة وليد القاضي',         'mother' => 'منى عبدالله',      'gender' => 'male'],
            ['name' => 'جميلة فهد السنباني',        'mother' => 'رحمة يوسف',       'gender' => 'female'],
            ['name' => 'مروان طارق الحداد',         'mother' => 'كوثر حسن',        'gender' => 'male'],
            ['name' => 'رنا ماجد المتوكل',          'mother' => 'أسماء فيصل',      'gender' => 'female'],
            ['name' => 'تامر سامي الجرادي',         'mother' => 'نهى عمار',        'gender' => 'male'],
            ['name' => 'ابتهال أنيس الشرفي',        'mother' => 'ياسمين سالم',     'gender' => 'female'],
            ['name' => 'نادر حاتم العزي',           'mother' => 'غادة إبراهيم',     'gender' => 'male'],
            ['name' => 'وعد بلال المقالح',          'mother' => 'رانيا خالد',       'gender' => 'female'],
            ['name' => 'شريف أيمن الزنداني',        'mother' => 'نسرين عادل',      'gender' => 'male'],
            ['name' => 'حنان يوسف بن ماضي',        'mother' => 'هناء محمود',       'gender' => 'female'],
            ['name' => 'أنور كمال الدويل',          'mother' => 'تهاني سعيد',      'gender' => 'male'],
            ['name' => 'شيماء ياسر العمري',         'mother' => 'إلهام طارق',      'gender' => 'female'],
        ];

        $statuses = ['pending', 'processing', 'ready', 'collected'];
        $yemeniCities = [
            'صنعاء - حي السنينة', 'صنعاء - شارع الزبيري', 'عدن - كريتر',
            'عدن - المنصورة', 'تعز - المظفر', 'تعز - القاهرة',
            'الحديدة - المدينة', 'إب - الظهار', 'المكلا - الديس الشرقية',
            'ذمار - شارع النور', 'مأرب - حي الروضة', 'المحويت - وسط المدينة',
        ];

        $statusComments = [
            'pending' => [
                'تم استلام الطلب وبدء المراجعة',
                'الطلب مسجل في النظام بانتظار التدقيق',
            ],
            'processing' => [
                'جاري التحقق من الوثائق الرسمية',
                'تمت المراجعة وجاري طباعة الجواز',
                'الطلب محول للمركز الرئيسي للمعالجة',
            ],
            'ready' => [
                'الجواز جاهز للاستلام من الفرع المحدد',
                'تمت الطباعة بنجاح - يرجى الحضور للاستلام',
            ],
            'collected' => [
                'تم تسليم الجواز لصاحبه بنجاح',
                'تم إغلاق الملف بعد التسليم',
            ],
        ];

        foreach ($applicants as $applicant) {
            $status = $statuses[array_rand($statuses)];
            $branch = $branches->random();
            $pickupBranch = $branches->random();

            $application = PassportApplication::create([
                'user_id' => $admin->id,
                'branch_id' => $branch->id,
                'pickup_branch_id' => $pickupBranch->id,
                'serial_number' => 'SER-'.strtoupper(Str::random(8)),
                'national_id' => fake()->numerify('##########'),
                'full_name' => $applicant['name'],
                'mother_name' => $applicant['mother'],
                'date_of_birth' => fake()->date('Y-m-d', '-18 years'),
                'gender' => $applicant['gender'],
                'address' => $yemeniCities[array_rand($yemeniCities)],
                'status' => $status,
                'tracking_number' => 'TRK-'.strtoupper(Str::random(10)),
            ]);

            // Create initial status update
            StatusUpdate::create([
                'passport_application_id' => $application->id,
                'status' => 'pending',
                'comment' => $statusComments['pending'][array_rand($statusComments['pending'])],
                'updated_by' => $admin->id,
            ]);

            // Add progression updates based on current status
            if (in_array($status, ['processing', 'ready', 'collected'])) {
                StatusUpdate::create([
                    'passport_application_id' => $application->id,
                    'status' => 'processing',
                    'comment' => $statusComments['processing'][array_rand($statusComments['processing'])],
                    'updated_by' => $admin->id,
                ]);
            }

            if (in_array($status, ['ready', 'collected'])) {
                StatusUpdate::create([
                    'passport_application_id' => $application->id,
                    'status' => 'ready',
                    'comment' => $statusComments['ready'][array_rand($statusComments['ready'])],
                    'updated_by' => $admin->id,
                ]);
            }

            if ($status === 'collected') {
                StatusUpdate::create([
                    'passport_application_id' => $application->id,
                    'status' => 'collected',
                    'comment' => $statusComments['collected'][array_rand($statusComments['collected'])],
                    'updated_by' => $admin->id,
                ]);
            }
        }
    }
}
