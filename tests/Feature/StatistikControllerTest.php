<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitorLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatistikControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_statistics_metrics_use_independent_period_queries(): void
    {
        $this->actingAs(User::factory()->create());

        VisitorLog::create([
            'visitor_id' => 'visitor-a',
            'url' => '/home',
            'path' => '/home',
            'page_type' => 'home',
            'is_admin' => false,
            'visited_at' => now(),
        ]);
        VisitorLog::create([
            'visitor_id' => 'visitor-b',
            'url' => '/view/gerbang',
            'path' => '/view/gerbang',
            'page_type' => 'panorama',
            'scene_id' => 'gerbang',
            'is_admin' => false,
            'visited_at' => now(),
        ]);

        $response = $this->get(route('admin.statistik.index'));

        $response->assertOk()
            ->assertViewHas('halamanPopuler', function ($pages) {
                return (int) $pages->get('home') === 1
                    && (int) $pages->get('panorama') === 1;
            })
            ->assertViewHas('panoramaPopuler', function ($panoramas) {
                return $panoramas->count() === 1
                    && $panoramas->first()->scene_id === 'gerbang';
            });
    }
}
