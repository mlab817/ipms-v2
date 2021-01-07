<?php

namespace Tests\Feature;

use App\Models\FeasibilityStudy;
use App\Models\FsStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndexFs()
    {
        $project = $this->createTestProject();
        $fs = FeasibilityStudy::factory()->make();
        $project->feasibility_study()->save($fs);

        $response = $this->json('GET', route('api.projects.fs.index', $project->slug))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'needs_assistance',
                    'fs_status_id',
                    'fs_status',
                    'y2016',
                    'y2017',
                    'y2018',
                    'y2019',
                    'y2020',
                    'y2021',
                    'y2022',
                    'y2023',
                    'y2024',
                    'y2025',
                ],
            ]);

        $response->dump();
    }

    public function testStoreFs()
    {
        $project = $this->createTestProject();

        $data = [
            'needs_assistance'  => $this->faker->boolean,
            'fs_status_id'      => FsStatus::factory()->create()->id,
            'y2016'             => 20,
            'y2017'             => 30,
            'y2018'             => 40,
            'y2019'             => 50,
            'y2020'             => 60,
            'y2021'             => 70,
            'y2022'             => 80,
            'y2023'             => 90,
            'y2024'             => 100,
            'y2025'             => 110,
        ];

        $response = $this->json('POST', route('api.projects.fs.store', $project->slug), $data)
            ->assertStatus(201)
            ->assertJson([
                'data'  => $data
            ]);

        $response->dump();
    }

    public function testShowFs()
    {
        $project = $this->createTestProject();
        $fs = FeasibilityStudy::factory()->make();
        $project->feasibility_study()->save($fs);

        $response = $this->json('GET', route('api.projects.fs.show', [
            'project'   => $project->slug,
            'fs'       => $fs->uuid,
        ]))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'needs_assistance',
                    'fs_status_id',
                    'fs_status',
                    'y2016',
                    'y2017',
                    'y2018',
                    'y2019',
                    'y2020',
                    'y2021',
                    'y2022',
                    'y2023',
                    'y2024',
                    'y2025',
                ],
            ]);

        $response->dump();
    }

    public function testUpdateFs()
    {
        $project = $this->createTestProject();
        $fs = FeasibilityStudy::factory()->make();
        $project->feasibility_study()->save($fs);

        $data = [
            'needs_assistance'  => $this->faker->boolean,
            'fs_status_id'  => FsStatus::factory()->create()->id,
            'y2016' => 20,
            'y2017' => 30,
            'y2018' => 40,
            'y2019' => 50,
            'y2020' => 60,
            'y2021' => 70,
            'y2022' => 80,
            'y2023' => 90,
            'y2024' => 100,
            'y2025' => 110,
        ];

        $response = $this->json('PUT', route('api.projects.fs.update', [
            'project'   => $project->slug,
            'fs'       => $fs->uuid,
        ]), $data)->assertStatus(200);

        $response->dump();
    }

    public function testDeleteFs()
    {
        $project = $this->createTestProject();
        $fs = FeasibilityStudy::factory()->make();
        $project->feasibility_study()->save($fs);

        $response = $this->json('DELETE', route('api.projects.fs.destroy', [
            'project'   => $project->slug,
            'fs'       => $fs->uuid,
        ]))
        ->assertStatus(200)
        ->assertJson([
            'message' => 'Success'
        ]);

        $response->dump();
    }
}