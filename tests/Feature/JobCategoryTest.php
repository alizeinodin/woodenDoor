<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Employer;
use App\Models\JobAd;
use App\Models\JobCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class JobCategoryTest extends TestCase
{
    use WithFaker;

    protected string $route_name = 'job_category';


    public function test_authorize_for_sanctum_user()
    {
        $response = $this->getJson(route("api.$this->route_name.index"));
        $response->assertStatus(401);
    }

    public function test_get_all_job_categories()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->getJson(route("api.$this->route_name.index"));
        $response->assertOk();
    }

    public function test_store_job_category()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $request = [
            'name' => $this->faker()->name,
        ];

        $response = $this->postJson(route("api.$this->route_name.store"), $request);
        $response->assertCreated();
    }

    public function test_show_job_category()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $jobCategory = new JobCategory();
        $jobCategory->name = $this->faker->name;
        $jobCategory->save();

        $response = $this->getJson(route("api.$this->route_name.show", ['job_category' => $jobCategory->id]));
        $response->assertOk();

    }

    public function test_update_job_category()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $jobCategory = new JobCategory();
        $jobCategory->name = $this->faker->name;
        $jobCategory->save();

        $request = [
            'name' => 'title2',
        ];

        $response = $this->patchJson(route("api.$this->route_name.update", ['job_category' => $jobCategory]), $request);
        $response->assertOk();

        $jobCategory = JobCategory::find($jobCategory->id);
        $this->assertEquals('title2', $jobCategory->title);
    }

    public function test_delete_job_category()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $jobCategory = new JobCategory();
        $jobCategory->name = $this->faker->name;
        $jobCategory->save();

        $response = $this->deleteJson(route("api.$this->route_name.destroy", ['job_category' => $jobCategory]));
        $response->assertStatus(204);
    }

    /**
     * @throws \Throwable
     */
    public function test_get_job_ads_of_job_categories()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $jobCategory = new JobCategory();
        $jobCategory->name = $this->faker->name;
        $jobCategory->save();


        $employer = new Employer();
        $employer->score = 10;

        $employer->user()->associate($user);
        $employer->save();

        $company = new Company();
        $company->persian_name = $this->faker->name;
        $company->english_name = $this->faker->name;
        $company->nick_name = $this->faker->userName;


        $user->employer->companies()->save($company);

        $jobAd = new JobAd();

        $jobAd->title = $this->faker->name;
        $jobAd->province = $this->faker->country;
        $jobAd->description = $this->faker->text;
        $jobAd->type_of_cooperation = '0';
        $jobAd->job_category_id = $jobCategory->id;

        $jobAd->company()->associate($company)->save();

        $result = $this->getJson(route("api.$this->route_name.job_ads", ['category' => $jobCategory]));
        $result->assertOk();

        $data = $result->decodeResponseJson()['data'][0];

        $this->assertEquals($jobAd->id, $data['id']);
    }

    public function test_get_companies_of_job_categories()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $jobCategory = new JobCategory();
        $jobCategory->name = $this->faker->name;
        $jobCategory->save();


        $employer = new Employer();
        $employer->score = 10;

        $employer->user()->associate($user);
        $employer->save();

        $company = new Company();
        $company->persian_name = $this->faker->name;
        $company->english_name = $this->faker->name;
        $company->nick_name = $this->faker->userName;
        $company->job_category_id = $jobCategory->id;


        $user->employer->companies()->save($company);

        $jobAd = new JobAd();

        $jobAd->title = $this->faker->name;
        $jobAd->province = $this->faker->country;
        $jobAd->description = $this->faker->text;
        $jobAd->type_of_cooperation = '0';
        $jobAd->job_category_id = $jobCategory->id;

        $jobAd->company()->associate($company)->save();

        $result = $this->getJson(route("api.$this->route_name.companies", ['category' => $jobCategory]));
        $result->assertOk();

        $data = $result->decodeResponseJson()['data'][0];

        $this->assertEquals($company->id, $data['id']);
    }

}
