<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testBasicTest()
    {
        $response = $this->get('/project');

        // $response->assertStatus(200);
        $response->assertOk();
    }

    public function h1Test()
    {
        $response = $this->get('/project');

        $value = 'Liste des projets';

        $response->assertSeeText($value, $escaped = true);
    }
}
