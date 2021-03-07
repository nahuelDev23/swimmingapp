<?php

namespace Tests;

use App\Models\Club;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function loggedIn($clubId)
    {
        // $club = Club::factory()->create();
        $user = User::factory()->create(['is_admin'=>'0','club_id' => $clubId]);
        return $this->actingAs($user);
    }

    protected function loggedInAdmin()
    {
        $club = Club::factory()->create();
        $user = User::factory()->create(['is_admin'=>'1','club_id' => $club->id]);
        return $this->actingAs($user);
    }
}
