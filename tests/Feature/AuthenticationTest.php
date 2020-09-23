<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use \App\Models\Project;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthenticationTest extends TestCase {

    use DatabaseMigrations;

    public function testUnauthenticatedUserCannotShowDashboard()
    {
        $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        $response = $this->get('/dashboard');
    }

    public function testAuthenticatedUserCanShowDashboard()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/dashboard')->assertStatus(200);
    }

    public function testUnauthenticatedUserCannotEditProject()
    {
        $project = Project::factory()->create();
        $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        $response = $this->get('/project/'.$project->id.'/edit');
    }

    public function testUserCannotEditAnotherUserProject()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);
        $response = $this->actingAs($user)->get('/project/'.$project->id.'/edit');
    }

    public function testAuthorizedUserCanEditProject()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'author'=> $user->id
        ]);
        $response = $this->actingAs($user)->get('/project/'.$project->id.'/edit')->assertStatus(200);
    }

    public function testNonAuthorCannotValidateProjectEdition()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);

        $response = $this->actingAs($user)->post('/project')->assertStatus(200);
    }
}
