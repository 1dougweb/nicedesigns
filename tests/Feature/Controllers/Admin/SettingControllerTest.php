<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Admin;

use App\Models\User;
use App\Services\AbacatePayService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class SettingControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $client;
    private AbacatePayService $abacatePayService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->client = User::factory()->create(['role' => 'client']);

        $this->abacatePayService = Mockery::mock(AbacatePayService::class);
        $this->app->instance(AbacatePayService::class, $this->abacatePayService);
    }

    /** @test */
    public function it_can_test_abacatepay_connection()
    {
        $this->abacatePayService->shouldReceive('testConnection')
            ->once()
            ->andReturn(['success' => true]);

        $response = $this->actingAs($this->admin)
            ->postJson('/api/admin/settings/test-abacatepay-connection');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Connection successful'
            ]);
    }

    /** @test */
    public function it_handles_abacatepay_connection_failure()
    {
        $this->abacatePayService->shouldReceive('testConnection')
            ->once()
            ->andReturn(['success' => false]);

        $response = $this->actingAs($this->admin)
            ->postJson('/api/admin/settings/test-abacatepay-connection');

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Please check your credentials'
            ]);
    }

    /** @test */
    public function it_handles_abacatepay_connection_error()
    {
        $this->abacatePayService->shouldReceive('testConnection')
            ->once()
            ->andThrow(new \Exception('API Error'));

        $response = $this->actingAs($this->admin)
            ->postJson('/api/admin/settings/test-abacatepay-connection');

        $response->assertStatus(500)
            ->assertJson([
                'success' => false,
                'message' => 'API Error'
            ]);
    }

    /** @test */
    public function it_requires_admin_role()
    {
        $response = $this->actingAs($this->client)
            ->postJson('/api/admin/settings/test-abacatepay-connection');

        $response->assertStatus(403);
    }
} 