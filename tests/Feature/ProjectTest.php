<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use \App\Models\Project;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProjectTest extends TestCase
{
    use DatabaseMigrations;

    public function testBasicTest()
    {
        $response = $this->get('/project');

        // $response->assertStatus(200);
        $response->assertOk();
    }

    public function h1Test()
    {
        $response = $this->get('/project');

        $value = '<h1>Liste des projets</h1>';

        $response->assertSeeText($value, $escaped = true);
    }
}
