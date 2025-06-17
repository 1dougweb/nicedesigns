<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Admin;

use App\Models\Invoice;
use App\Models\User;
use App\Services\AbacatePayService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class InvoiceControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $client;
    private Invoice $invoice;
    private AbacatePayService $abacatePayService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->client = User::factory()->create(['role' => 'client']);
        $this->invoice = Invoice::factory()->create([
            'user_id' => $this->client->id,
            'total' => 100.00,
            'status' => 'pending'
        ]);

        $this->abacatePayService = Mockery::mock(AbacatePayService::class);
        $this->app->instance(AbacatePayService::class, $this->abacatePayService);
    }

    /** @test */
    public function it_can_generate_pix_charge()
    {
        $this->abacatePayService->shouldReceive('createPixCharge')
            ->once()
            ->andReturn([
                'id' => 'ch_123',
                'status' => 'pending',
                'pix_code' => 'pix_code_123',
                'pix_qr_code' => 'pix_qr_code_123'
            ]);

        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/invoices/{$this->invoice->id}/pix");

        $response->assertStatus(200)
            ->assertJson([
                'id' => 'ch_123',
                'status' => 'pending',
                'pix_code' => 'pix_code_123',
                'pix_qr_code' => 'pix_qr_code_123'
            ]);
    }

    /** @test */
    public function it_can_generate_boleto_charge()
    {
        $this->abacatePayService->shouldReceive('createBoletoCharge')
            ->once()
            ->andReturn([
                'id' => 'ch_123',
                'status' => 'pending',
                'boleto_url' => 'boleto_url_123',
                'boleto_barcode' => 'boleto_barcode_123'
            ]);

        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/invoices/{$this->invoice->id}/boleto");

        $response->assertStatus(200)
            ->assertJson([
                'id' => 'ch_123',
                'status' => 'pending',
                'boleto_url' => 'boleto_url_123',
                'boleto_barcode' => 'boleto_barcode_123'
            ]);
    }

    /** @test */
    public function it_can_generate_charge_with_all_payment_methods()
    {
        $this->abacatePayService->shouldReceive('createCharge')
            ->once()
            ->andReturn([
                'id' => 'ch_123',
                'status' => 'pending',
                'pix_code' => 'pix_code_123',
                'pix_qr_code' => 'pix_qr_code_123',
                'boleto_url' => 'boleto_url_123',
                'boleto_barcode' => 'boleto_barcode_123'
            ]);

        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/invoices/{$this->invoice->id}/charge");

        $response->assertStatus(200)
            ->assertJson([
                'id' => 'ch_123',
                'status' => 'pending',
                'pix_code' => 'pix_code_123',
                'pix_qr_code' => 'pix_qr_code_123',
                'boleto_url' => 'boleto_url_123',
                'boleto_barcode' => 'boleto_barcode_123'
            ]);
    }

    /** @test */
    public function it_can_check_charge_status()
    {
        $this->invoice->update([
            'abacatepay_billing_id' => 'ch_123',
            'abacatepay_status' => 'pending'
        ]);

        $this->abacatePayService->shouldReceive('getChargeStatus')
            ->once()
            ->andReturn([
                'id' => 'ch_123',
                'status' => 'paid'
            ]);

        $response = $this->actingAs($this->admin)
            ->getJson("/api/admin/invoices/{$this->invoice->id}/status");

        $response->assertStatus(200)
            ->assertJson([
                'id' => 'ch_123',
                'status' => 'paid'
            ]);
    }

    /** @test */
    public function it_can_cancel_charge()
    {
        $this->invoice->update([
            'abacatepay_billing_id' => 'ch_123',
            'abacatepay_status' => 'pending'
        ]);

        $this->abacatePayService->shouldReceive('cancelCharge')
            ->once()
            ->andReturn([
                'id' => 'ch_123',
                'status' => 'cancelled'
            ]);

        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/invoices/{$this->invoice->id}/cancel");

        $response->assertStatus(200)
            ->assertJson([
                'id' => 'ch_123',
                'status' => 'cancelled'
            ]);
    }

    /** @test */
    public function it_validates_invoice_can_generate_charge()
    {
        $this->invoice->update(['status' => 'paid']);

        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/invoices/{$this->invoice->id}/pix");

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Invoice is already paid'
            ]);
    }

    /** @test */
    public function it_validates_invoice_has_charge_before_cancelling()
    {
        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/invoices/{$this->invoice->id}/cancel");

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Invoice has no active charge'
            ]);
    }

    /** @test */
    public function it_validates_invoice_not_paid_before_cancelling()
    {
        $this->invoice->update([
            'abacatepay_billing_id' => 'ch_123',
            'abacatepay_status' => 'paid'
        ]);

        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/invoices/{$this->invoice->id}/cancel");

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Cannot cancel paid invoice'
            ]);
    }

    /** @test */
    public function it_handles_api_errors()
    {
        $this->abacatePayService->shouldReceive('createPixCharge')
            ->once()
            ->andThrow(new \Exception('API Error'));

        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/invoices/{$this->invoice->id}/pix");

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'API Error'
            ]);
    }
} 