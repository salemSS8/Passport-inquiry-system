<?php

namespace Database\Factories;

use App\Models\PassportApplication;
use App\Models\StatusUpdate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StatusUpdate>
 */
class StatusUpdateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $comments = [
            'pending' => [
                'تم استلام الطلب وبانتظار المراجعة الأولية',
                'الطلب في قائمة الانتظار',
                'تم استلام المستندات المطلوبة',
            ],
            'processing' => [
                'جاري مراجعة البيانات والتحقق من الهوية',
                'الطلب قيد المعالجة الفنية',
                'جاري طباعة الجواز في المركز الرئيسي',
            ],
            'ready' => [
                'الجواز جاهز للاستلام من الفرع المختار',
                'تم الانتهاء من الطباعة وبانتظار حضور صاحب الطلب',
                'نرجو الحضور لاستلام الجواز في أقرب وقت',
            ],
            'collected' => [
                'تم تسليم الجواز لصاحبه رسمياً',
                'تم استلام الجواز وإغلاق الملف',
                'اكتملت العملية بنجاح',
            ],
        ];

        $status = $this->faker->randomElement(['pending', 'processing', 'ready', 'collected']);

        return [
            'passport_application_id' => PassportApplication::factory(),
            'status' => $status,
            'comment' => $this->faker->randomElement($comments[$status]),
            'updated_by' => User::factory(),
        ];
    }
}
