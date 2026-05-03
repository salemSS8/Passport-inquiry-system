<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            ['name' => 'فرع صنعاء',     'code' => 'BR-SANA', 'location' => 'شارع الستين - أمانة العاصمة صنعاء'],
            ['name' => 'فرع عدن',       'code' => 'BR-ADEN', 'location' => 'خور مكسر - محافظة عدن'],
            ['name' => 'فرع تعز',       'code' => 'BR-TAIZ', 'location' => 'شارع جمال - وسط مدينة تعز'],
            ['name' => 'فرع الحديدة',    'code' => 'BR-HODH', 'location' => 'شارع صنعاء - مدينة الحديدة'],
            ['name' => 'فرع إب',        'code' => 'BR-IBBB', 'location' => 'شارع الثورة - مدينة إب'],
            ['name' => 'فرع المكلا',     'code' => 'BR-MUKL', 'location' => 'حي الديس - المكلا - حضرموت'],
            ['name' => 'فرع سيئون',     'code' => 'BR-SAYU', 'location' => 'شارع المطار - سيئون - حضرموت'],
            ['name' => 'فرع المحويت',    'code' => 'BR-MAHW', 'location' => 'وسط مدينة المحويت'],
            ['name' => 'فرع ذمار',      'code' => 'BR-DHMR', 'location' => 'شارع الجمهورية - مدينة ذمار'],
            ['name' => 'فرع مأرب',      'code' => 'BR-MARB', 'location' => 'حي الروضة - مدينة مأرب'],
        ];

        foreach ($branches as $branch) {
            Branch::updateOrCreate(
                ['code' => $branch['code']],
                $branch
            );
        }
    }
}
