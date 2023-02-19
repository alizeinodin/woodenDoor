<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Employer;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    public function test_authorize_for_sanctum_user()
    {
        $response = $this->getJson(route('api.company.index'));
        $response->assertStatus(401);
    }

    public function test_get_all_companies()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->getJson(route('api.company.index'));
        $response->assertOk();
    }

    public function test_get_employers_company()
    {
        $user = User::factory()->create();

        $employer = new Employer();
        $employer->score = 10;

        $employer->user()->associate($user);
        $employer->save();

        $company = new Company();
        $company->persian_name = 'test1';
        $company->english_name = 'test2';
        $company->nick_name = 'test';

        $user->employer->companies()->save($company);

        Sanctum::actingAs($user);

        $response = $this->postJson(route('api.company.my_companies'));
        $response->assertOk();
    }
}
