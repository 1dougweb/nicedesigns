<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class AbacatePayWebhookControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $webhookSecret;
    private User $user;
    private Invoice $invoice;

    protected function setUp(): void
    {
        parent::setUp();

        $this->webhookSecret = 'test_secret';
        Config::set('services.abacatepay.webhook_secret', $this->webhookSecret);

        $this->user = User::factory()->create();
        $this->invoice = Invoice::factory()->create([
            'user_id' => $this->user->id,
            'total' => 100.00,
            'status' => 'pending'
        ]);
    }

    /** @test */
    public function it_validates_webhook_signature()
    {
        $payload = [
            'id' => 'ch_123',
            'status' => 'paid'
        ];

        $response = $this->postJson('/api/webhooks/abacatepay', $payload, [
            'X-AbacatePay-Signature' => 'invalid_signature'
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function it_processes_paid_webhook()
    {
        $payload = [
            'id' => 'ch_123',
            'status' => 'paid',
            'payment_method' => 'pix'
        ];

        $signature = hash_hmac('sha256', json_encode($payload), $this->webhookSecret);

        $response = $this->postJson('/api/webhooks/abacatepay', $payload, [
            'X-AbacatePay-Signature' => $signature
        ]);

        $response->assertStatus(200);

        $this->invoice->refresh();
        $this->assertEquals('paid', $this->invoice->status);
        $this->assertEquals('ch_123', $this->invoice->abacatepay_billing_id);
        $this->assertEquals('pix', $this->invoice->payment_method);
    }

    /** @test */
    public function it_processes_cancelled_webhook()
    {
        $payload = [
            'id' => 'ch_123',
            'status' => 'cancelled'
        ];

        $signature = hash_hmac('sha256', json_encode($payload), $this->webhookSecret);

        $response = $this->postJson('/api/webhooks/abacatepay', $payload, [
            'X-AbacatePay-Signature' => $signature
        ]);

        $response->assertStatus(200);

        $this->invoice->refresh();
        $this->assertEquals('cancelled', $this->invoice->status);
    }

    /** @test */
    public function it_handles_invalid_payload()
    {
        $payload = [
            'status' => 'paid'
        ];

        $signature = hash_hmac('sha256', json_encode($payload), $this->webhookSecret);

        $response = $this->postJson('/api/webhooks/abacatepay', $payload, [
            'X-AbacatePay-Signature' => $signature
        ]);

        $response->assertStatus(400);
    }

    /** @test */
    public function it_handles_invalid_invoice()
    {
        $payload = [
            'id' => 'invalid_id',
            'status' => 'paid'
        ];

        $signature = hash_hmac('sha256', json_encode($payload), $this->webhookSecret);

        $response = $this->postJson('/api/webhooks/abacatepay', $payload, [
            'X-AbacatePay-Signature' => $signature
        ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_handles_server_error()
    {
        $payload = [
            'id' => 'ch_123',
            'status' => 'paid'
        ];

        $signature = hash_hmac('sha256', json_encode($payload), $this->webhookSecret);

        $this->invoice->delete();

        $response = $this->postJson('/api/webhooks/abacatepay', $payload, [
            'X-AbacatePay-Signature' => $signature
        ]);

        $response->assertStatus(500);
    }
} 