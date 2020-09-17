<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use \App\Models\Project;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ProjectTest extends TestCase
{
    use DatabaseMigrations;

    public function testStatusIs200WhenGetProjectPage()
    {
        $response = $this->get('/project');

        // $response->assertStatus(200);
        $response->assertOk();
    }

    public function testPresenceTagH1WithListeDesProjets()
    {
        $response = $this->get('/project');

        $value = '<h1>Liste des projets</h1>';

        $response->assertSee($value, false);
    }

    public function testRelationIfProjectHasUser()
    {
        $userName ='SuperMan';
        $projectName = 'SuperProject';

        // GIVEN
        $user = User::factory()
            ->has(Project::factory()->state([
                'name' => $projectName
            ]))
            ->create();

        $project = Project::factory()
            ->for(User::factory()->state([
                'name' => $userName
            ]))
            ->create();

        // WHEN
        $actualProjectUserName = $project->user->name;
        $actualUserProjectName = $user->projects()->first()->name;

        // THEN
        $this->assertEquals($userName, $actualProjectUserName);
        $this->assertEquals($projectName, $actualUserProjectName);

    }

    public function testIfProjectNameIsOnProjectView()
    {
        Project::factory()
            ->count(5)
            ->create([
                'name'=> 'My project'
            ]);
        $response = $this->get('/project');
        $response->assertSee('My project', false);
    }

    public function testIfProjectNameIsOnProjectDetailsView()
    {
        Project::factory()
            ->create([
                'name'=> 'My project'
            ]);
        $response = $this->get('/project/1');
        $response->assertSee('My project', false);
    }

    public function testIfProjectAuthorNameIsOnProjectDetailView()
    {
        User::factory()->has(Project::factory())
            ->create([
                'name'=> 'Macron'
            ]);
        $response = $this->get('/project/1');
        $response->assertSee('Macron', false);

    }
}
