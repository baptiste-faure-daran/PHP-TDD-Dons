<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \App\Models\Project;

class APITest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIfProjectNameIsOnProjectView()
    {
        Project::factory()
            ->count(5)
            ->create([
                'name'=> 'My project'
            ]);
        $response = $this->get('/api/project');
        $response->assertSee('My project', false);
    }
}
