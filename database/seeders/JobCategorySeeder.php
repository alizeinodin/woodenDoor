<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobCategory::create([
            'title' => 'پیشفرض',
            'link' => Str::slug('پیشفرض'),
        ]);

        JobCategory::create([
            'title' => 'دیجیتال مارکتینگ و سئو',
            'link' => Str::slug('دیجیتال مارکتینگ و سئو'),

        ]);

        JobCategory::create([
            'title' => 'توسعه نرم افزار و برنامه نویسی',
            'link' => Str::slug('توسعه نرم افزار و برنامه نویسی'),
        ]);

        JobCategory::create([
            'title' => 'تست نرم افزار',
            'link' => Str::slug('تست نرم افزار'),
        ]);

        JobCategory::create([
            'title' => 'شبکه و دواپس',
            'link' => Str::slug('شبکه و دواپس'),
        ]);
        JobCategory::create([
            'title' => 'علوم داده و هوش مصنوعی',
            'link' => Str::slug('علوم داده و هوش مصنوعی'),
        ]);
        JobCategory::create([
            'title' => 'طراحی بازی',
            'link' => Str::slug('طراحی بازی'),
        ]);
        JobCategory::create([
            'title' => 'گرافیک',
            'link' => Str::slug('گرافیک'),
        ]);
        JobCategory::create([
            'title' => 'مدیریت بیمه',
            'link' => Str::slug('مدیریت بیمه'),
        ]);
        JobCategory::create([
            'title' => 'فروشگاه و رستوران',
            'link' => Str::slug('فروشگاه و رستوران'),
        ]);
        JobCategory::create([
            'title' => 'ترجمه و تولید محتوا',
            'link' => Str::slug('ترجمه و تولید محتوا'),
        ]);
    }
}
