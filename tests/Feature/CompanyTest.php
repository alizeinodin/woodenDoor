<?php

namespace Tests\Feature;

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
}
