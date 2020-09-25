<?php

namespace Tests\Feature;

use App\Mail\DonationReceived;
use App\Mail\DonationSent;
use App\Models\Donation;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Tests\TestCase;
use \App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthenticationTest extends TestCase
{

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
        $response = $this->get('/project/' . $project->id . '/edit');
    }

    public function testUserCannotAccessEditFormOnAnotherUserProject()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);
        $response = $this->actingAs($user)->get('/project/' . $project->id . '/edit');
    }

    public function testAuthorUserCanAccessEditProjectForm()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'author' => $user->id
        ]);
        $response = $this->actingAs($user)->get('/project/' . $project->id . '/edit')->assertStatus(200);
    }

    public function testAuthorUserCanSubmitEditionProjectForm()
    {
        // GIVEN
        $newProjectName = 'NewProject';
        $newProjectDescription = 'DamnDamnDamn';
        $formData = [
            'name' => $newProjectName,
            'description' => $newProjectDescription
        ];
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'author' =>$user->id
        ]);

        // WHEN
        $response = $this->actingAs($user)->put('project/' . $project->id . '', $formData);

        // THEN
        $response = $this->assertDatabaseHas('projects', [
            'name' => $newProjectName,
            'description' => $newProjectDescription,
        ]);
    }

    public function testNonAuthorCannotSubmitProjectEditionForm()
    {
        // GIVEN
        $newProjectName = 'NewProject';
        $newProjectDescription = 'DamnDamnDamn';
        $formData = [
            'name' => $newProjectName,
            'description' => $newProjectDescription
        ];
        $user = User::factory()->create();
        $project = Project::factory()->create();

        // WHEN
        $this->expectException('exception');
        $response = $this->actingAs($user)->put('project/' . $project->id . '', $formData);

        // THEN
        $response = $this->assertDatabaseMissing('projects', [
            'name' => $newProjectName,
            'description' => $newProjectDescription,
        ]);
    }

    public function testNotUserCannotSubmitDonationForm()
    {
        $donation = Donation::factory()->create([
            'amount' => 15
        ]);
        $this->expectException(\Illuminate\Auth\AuthenticationException::class);

        $response = $this->post('/projectDonation/' . $donation->project_id . '', ['amount' => $donation])->assertStatus(200);
    }

    public function testUserCanSubmitDonationForm()
    {
        // GIVEN
        $project = Project::factory()->create();

        // WHEN
        $response = $this->actingAs($project->user)->post('/projectDonation/' . $project->id . '', ['amount' => '10', 'project_id' => $project->id])->assertStatus(302);

        // THEN
        //   $this->assertDatabaseHas('donations', ['amount'=> '10', 'user_id'=>$project->author, 'project_id'=>$project->id]);
        $this->get('projectDonation/' . $project->id . '')->assertSee($project->amount);
    }

    public function testDonationMailIsSentToAuthorAndDonator()
    {
        // GIVEN
        Mail::fake();
        Mail::assertNothingSent();
        $project=Project::factory()->create();

        // WHEN
        $response = $this->actingAs($project->user)->post('/projectDonation/'. $project->id . '', ['amount' => '10', 'project_id' => $project->id]);

        // THEN
        Mail::assertSent(function (DonationSent $mail) use ($project) {
            return $mail->donation->id === $project->donations->last()->id;
        });

        Mail::assertSent(function (DonationReceived $mail) use ($project) {
            return $mail->donation->id === $project->donations->last()->id;
        });
    }

}
