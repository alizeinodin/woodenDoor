<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create-post']);
        Permission::create(['name' => 'update-post']);
        Permission::create(['name' => 'delete-post']);

        Permission::create(['name' => 'create-jobAd']);
        Permission::create(['name' => 'update-jobAd']);
        Permission::create(['name' => 'delete-jobAd']);

        Permission::create(['name' => 'create-jobOffer']); // request for a job ad
        Permission::create(['name' => 'delete-jobOffer']); // delete a request

        Permission::create(['name' => 'create-company']);
        Permission::create(['name' => 'update-company']);
        Permission::create(['name' => 'delete-company']);

        Permission::create(['name' => 'create-category']);
        Permission::create(['name' => 'update-category']);
        Permission::create(['name' => 'delete-category']);

        Permission::create(['name' => 'create-media']);
        Permission::create(['name' => 'update-media']);
        Permission::create(['name' => 'delete-media']);

        Permission::create(['name' => 'create-comment']);
        Permission::create(['name' => 'update-comment']);
        Permission::create(['name' => 'delete-comment']);

        Permission::create(['name' => 'like_post']);
        Permission::create(['name' => 'dislike_post']);
        Permission::create(['name' => 'store_post']);

        Permission::create(['name' => 'create-skill']);
        Permission::create(['name' => 'update-skill']);
        Permission::create(['name' => 'delete-skill']);

        Permission::create(['name' => 'create-work_experience']);
        Permission::create(['name' => 'update-work_experience']);
        Permission::create(['name' => 'delete-work_experience']);

        Permission::create(['name' => 'create-education_experience']);
        Permission::create(['name' => 'update-education_experience']);
        Permission::create(['name' => 'delete-education_experience']);


        $employee = Role::create([
            'name' => 'Employee',
        ]);

        $employer = Role::create([
            'name' => 'Employer',
        ]);

        $employee->givePermissionTo([
            'create-post',
            'update-post',
            'delete-post',

            'create-jobOffer',
            'delete-jobOffer',

            'create-category',
            'update-category',
            'delete-category',

            'create-media',
            'update-media',
            'delete-media',

            'create-comment',
            'update-comment',
            'delete-comment',

            'like_post',
            'dislike_post',
            'store_post',

            'create-skill',
            'update-skill',
            'delete-skill',

            'create-work_experience',
            'update-work_experience',
            'delete-work_experience',

            'create-education_experience',
            'update-education_experience',
            'delete-education_experience',
        ]);

        $employer->givePermissionTo([
            'create-post',
            'update-post',
            'delete-post',

            'create-jobAd',
            'update-jobAd',
            'delete-jobAd',

            'create-company',
            'update-company',
            'delete-company',

            'create-media',
            'update-media',
            'delete-media',

            'create-comment',
            'update-comment',
            'delete-comment',

            'like_post',
            'dislike_post',
            'store_post',

        ]);
    }
}
