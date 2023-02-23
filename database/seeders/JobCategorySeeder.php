<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobCategory::create([
            'name' => 'پیشفرض',
        ]);

        JobCategory::create([
            'name' => 'دیجیتال مارکتینگ و سئو',
        ]);

        JobCategory::create([
            'name' => 'توسعه نرم افزار و برنامه نویسی',
        ]);

        JobCategory::create([
            'name' => 'تست نرم افزار',
        ]);

        JobCategory::create([
            'name' => 'شبکه و دواپس',
        ]);
        JobCategory::create([
            'name' => 'علوم داده و هوش مصنوعی',
        ]);
        JobCategory::create([
            'name' => 'طراحی بازی',
        ]);
        JobCategory::create([
            'name' => 'گرافیک',
        ]);
        JobCategory::create([
            'name' => 'مدیریت بیمه',
        ]);
        JobCategory::create([
            'name' => 'فروشگاه و رستوران',
        ]);
        JobCategory::create([
            'name' => 'ترجمه و تولید محتوا',
        ]);
    }
}
