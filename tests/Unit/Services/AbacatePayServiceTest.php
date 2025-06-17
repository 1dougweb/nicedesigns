<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\AbacatePayService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AbacatePayServiceTest extends TestCase
{
    use RefreshDatabase;

    private AbacatePayService $service;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new AbacatePayService();
        $this->user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'document' => '12345678900'
        ]);
    }

    /** @test */
    public function it_can_create_or_update_customer()
    {
        Http::fake([
            '*/customers' => Http::response([
                'id' => 'cus_123',
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'document' => '12345678900'
            ], 200)
        ]);

        $response = $this->service->createOrUpdateCustomer($this->user);

        $this->assertEquals('cus_123', $response['id']);
        $this->assertEquals('John Doe', $response['name']);
        $this->assertEquals('john@example.com', $response['email']);
        $this->assertEquals('12345678900', $response['document']);
    }

    /** @test */
    public function it_can_create_pix_charge()
    {
        Http::fake([
            '*/charges' => Http::response([
                'id' => 'ch_123',
                'status' => 'pending',
                'pix_code' => 'pix_code_123',
                'pix_qr_code' => 'pix_qr_code_123'
            ], 200)
        ]);

        $response = $this->service->createPixCharge($this->user, 100.00);

        $this->assertEquals('ch_123', $response['id']);
        $this->assertEquals('pending', $response['status']);
        $this->assertEquals('pix_code_123', $response['pix_code']);
        $this->assertEquals('pix_qr_code_123', $response['pix_qr_code']);
    }

    /** @test */
    public function it_can_create_boleto_charge()
    {
        Http::fake([
            '*/charges' => Http::response([
                'id' => 'ch_123',
                'status' => 'pending',
                'boleto_url' => 'boleto_url_123',
                'boleto_barcode' => 'boleto_barcode_123'
            ], 200)
        ]);

        $response = $this->service->createBoletoCharge($this->user, 100.00);

        $this->assertEquals('ch_123', $response['id']);
        $this->assertEquals('pending', $response['status']);
        $this->assertEquals('boleto_url_123', $response['boleto_url']);
        $this->assertEquals('boleto_barcode_123', $response['boleto_barcode']);
    }

    /** @test */
    public function it_can_create_charge_with_all_payment_methods()
    {
        Http::fake([
            '*/charges' => Http::response([
                'id' => 'ch_123',
                'status' => 'pending',
                'pix_code' => 'pix_code_123',
                'pix_qr_code' => 'pix_qr_code_123',
                'boleto_url' => 'boleto_url_123',
                'boleto_barcode' => 'boleto_barcode_123'
            ], 200)
        ]);

        $response = $this->service->createCharge($this->user, 100.00);

        $this->assertEquals('ch_123', $response['id']);
        $this->assertEquals('pending', $response['status']);
        $this->assertEquals('pix_code_123', $response['pix_code']);
        $this->assertEquals('pix_qr_code_123', $response['pix_qr_code']);
        $this->assertEquals('boleto_url_123', $response['boleto_url']);
        $this->assertEquals('boleto_barcode_123', $response['boleto_barcode']);
    }

    /** @test */
    public function it_can_get_charge_status()
    {
        Http::fake([
            '*/charges/ch_123' => Http::response([
                'id' => 'ch_123',
                'status' => 'paid'
            ], 200)
        ]);

        $response = $this->service->getChargeStatus('ch_123');

        $this->assertEquals('ch_123', $response['id']);
        $this->assertEquals('paid', $response['status']);
    }

    /** @test */
    public function it_can_cancel_charge()
    {
        Http::fake([
            '*/charges/ch_123/cancel' => Http::response([
                'id' => 'ch_123',
                'status' => 'cancelled'
            ], 200)
        ]);

        $response = $this->service->cancelCharge('ch_123');

        $this->assertEquals('ch_123', $response['id']);
        $this->assertEquals('cancelled', $response['status']);
    }

    /** @test */
    public function it_can_test_connection()
    {
        Http::fake([
            '*/test-connection' => Http::response([
                'success' => true
            ], 200)
        ]);

        $response = $this->service->testConnection();

        $this->assertTrue($response['success']);
    }

    /** @test */
    public function it_handles_api_errors()
    {
        Http::fake([
            '*/test-connection' => Http::response([
                'error' => 'Invalid credentials'
            ], 401)
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid credentials');

        $this->service->testConnection();
    }
} 