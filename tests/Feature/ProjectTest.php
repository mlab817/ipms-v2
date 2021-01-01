<?php

namespace Tests\Feature;

use App\Http\Resources\ProjectResource;
use App\Models\Allocation;
use App\Models\ApprovalLevel;
use App\Models\Basis;
use App\Models\CipType;
use App\Models\Disbursement;
use App\Models\FeasibilityStudy;
use App\Models\FundingSource;
use App\Models\Gad;
use App\Models\ImplementationMode;
use App\Models\Nep;
use App\Models\PapType;
use App\Models\PdpChapter;
use App\Models\PipTypology;
use App\Models\PreparationDocument;
use App\Models\Project;
use App\Models\ProjectAudit;
use App\Models\ProjectStatus;
use App\Models\ReadinessLevel;
use App\Models\ResettlementActionPlan;
use App\Models\RightOfWay;
use App\Models\SpatialCoverage;
use App\Models\Tier;
use App\Models\User;
use Database\Seeders\ApprovalLevelsTableSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    const CONTRIBUTOR_EMAIL = 'contributor@example.com';
    const EDITOR_EMAIL = 'editor@example.com';
    const ADMIN_EMAIL = 'admin@example.com';

    public function test_it_returns_a_collection_of_projects()
    {
        $this->withoutExceptionHandling();

        $projects = Project::factory()->count(25)->create();

        $response = $this->get(route('api.projects.index'))
            ->assertStatus(200);

        $this->assertArrayHasKey('data', $response->json());

        $response->dump();
    }

    public function test_it_returns_401_if_user_is_unauthorized()
    {
        $project = [];

        $this->postJson(route('api.projects.store'), $project)
            ->assertStatus(401);
    }

    public function test_it_returns_403_unauthorized_to_create_project()
    {
//        $this->withoutExceptionHandling();

        $project = [];

        $this
            ->actingAs(User::factory()->create())
            ->postJson(route('api.projects.store'), $project)
            ->assertStatus(403);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_creates_a_project()
    {
        $this->withoutExceptionHandling();

        $project = [
            'code' => $this->faker->isbn13,
            'title' => 'new project',
            'pap_type_id' => PapType::factory()->create()->id,
            'regular_program' => $this->faker->boolean,
            'description' => 'description',
            'spatial_coverage_id' => SpatialCoverage::factory()->create()->id,
            'iccable' => $this->faker->boolean,
            'pip' => $this->faker->boolean,
            'pip_typology_id'   => PipTypology::factory()->create()->id,
            'research' => $this->faker->boolean,
            'cip' => $this->faker->boolean,
            'cip_type_id' => CipType::factory()->create()->id,
            'trip' => $this->faker->boolean,
            'rdip' => $this->faker->boolean,
            'rdc_endorsement_required' => $this->faker->boolean,
            'rdc_endorsed' => $this->faker->boolean,
            'rdc_endorsed_date' => $this->faker->date(),
            'other_infrastructure' => $this->faker->word,
            'risk' => $this->faker->paragraph,
            'pdp_chapter_id' => PdpChapter::factory()->create()->id,
            'no_pdp_indicator' => $this->faker->boolean,
            'gad_id' => Gad::factory()->create()->id,
            'target_start_year' => $this->faker->randomDigit + 2000,
            'target_end_year' => $this->faker->randomDigit + 2000,
            'has_fs' => $this->faker->boolean,
            'has_row' => $this->faker->boolean,
            'has_rap' => $this->faker->boolean,
            'employment_generated' => $this->faker->word,
            'funding_source_id' => FundingSource::factory()->create()->id,
            'implementation_mode_id' => ImplementationMode::factory()->create()->id,
            'other_fs' => $this->faker->word,
            'project_status_id' => ProjectStatus::factory()->create()->id,
            'updates' => $this->faker->paragraph,
            'updates_date' => $this->faker->date(),
            'uacs_code' => $this->faker->isbn13,
            'tier_id' => Tier::factory()->create()->id,
            'approval_level_id' => ApprovalLevel::factory()->create()->id,
            'approval_date' => $this->faker->date(),
            'regions'   => [1,2,3]
        ];

        $response = $this
            ->actingAs(User::where('email',self::CONTRIBUTOR_EMAIL)->first())
            ->json('POST', route('api.projects.store'), $project);

        $response->assertStatus(201);

        $response->dump();
    }

    public function test_it_gets_a_project_by_slug()
    {
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $response = $this
            ->actingAs(User::factory()->create())
            ->json('GET', route('api.projects.show', $project->slug))
            ->assertStatus(200);

        $response->dump();
    }

    public function test_admin_can_delete_a_project()
    {
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $response = $this
            ->actingAs(User::where('email', self::ADMIN_EMAIL)->first())
            ->json('DELETE', route('api.projects.delete', $project->slug))
            ->assertStatus(204);

        $response->dump();
    }

    public function test_owner_can_delete_own_project()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $project = Project::factory()->create();

        $project->created_by = $user->id;
        $project->save();

        $response = $this
            ->actingAs($user)
            ->json('DELETE', route('api.projects.delete', $project->slug))
            ->assertStatus(204);

        $response->dump();
    }

    /**
     *
     */
//    public function test_it_updates_a_project()
//    {
//        $project = Project::factory()->create();
//
//        $user = User::factory()->create();
//        $user->assignRole('contributor');
//
//        $update = [
//            'title' => 'New title',
//        ];
//
//        $response = $this
//            ->actingAs($user)
//            ->json('PUT', route('api.projects.update', $project->id), $update);
//
//        $response->assertStatus(200);
//
//        $response->dump();
//    }
}
