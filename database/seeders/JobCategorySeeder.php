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
            'title' => 'پیشفرض',
        ]);

        JobCategory::create([
            'title' => 'دیجیتال مارکتینگ و سئو',
        ]);

        JobCategory::create([
            'title' => 'توسعه نرم افزار و برنامه نویسی',
        ]);

        JobCategory::create([
            'title' => 'تست نرم افزار',
        ]);

        JobCategory::create([
            'title' => 'شبکه و دواپس',
        ]);
        JobCategory::create([
            'title' => 'علوم داده و هوش مصنوعی',
        ]);
        JobCategory::create([
            'title' => 'طراحی بازی',
        ]);
        JobCategory::create([
            'title' => 'گرافیک',
        ]);
        JobCategory::create([
            'title' => 'مدیریت بیمه',
        ]);
        JobCategory::create([
            'title' => 'فروشگاه و رستوران',
        ]);
        JobCategory::create([
            'title' => 'ترجمه و تولید محتوا',
        ]);
    }
}
