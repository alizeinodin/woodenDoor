<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use DatabaseTruncation;

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

    public function test_store_company()
    {
        $user = User::factory()->create();

        $employer = new Employer();
        $employer->score = 10;

        $employer->user()->associate($user);
        $employer->save();

        Sanctum::actingAs($user);

        $request = [
            'persian_name' => 'sherkat',
            'english_name' => 'company',
            'nick_name' => 'companyTest',
        ];

        $response = $this->postJson(route('api.company.store', $request));
        $response->assertCreated();
    }

    public function test_show_company()
    {
        $user = User::factory()->create();

        $employer = new Employer();
        $employer->score = 10;

        $employer->user()->associate($user);
        $employer->save();

        Sanctum::actingAs($user);

        $company = new Company();
        $company->persian_name = 'test3';
        $company->english_name = 'test3';
        $company->nick_name = '2test';

        $user->employer->companies()->save($company);

        $response = $this->getJson(route('api.company.show', ['company' => $company->id]));
        $response->assertOk();

    }

    public function test_update_company()
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

        $request = [
            'persian_name' => 'farsi',
            'english_name' => 'english',
            'nick_name' => 'google',
        ];

        $response = $this->patchJson(route('api.company.update', ['company' => $company]), $request);
        $response->assertOk();

        $company = Company::find($company->id);
        $this->assertEquals('google', $company->nick_name);
    }
}
