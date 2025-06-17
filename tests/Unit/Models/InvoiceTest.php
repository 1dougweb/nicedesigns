<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Invoice $invoice;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->invoice = Invoice::factory()->create([
            'user_id' => $this->user->id,
            'total' => 100.00,
            'status' => 'pending'
        ]);
    }

    /** @test */
    public function it_can_generate_abacatepay_charge()
    {
        $this->assertTrue($this->invoice->canGenerateAbacatePayCharge());

        $this->invoice->update(['status' => 'paid']);
        $this->assertFalse($this->invoice->canGenerateAbacatePayCharge());

        $this->invoice->update([
            'status' => 'pending',
            'abacatepay_billing_id' => 'ch_123',
            'abacatepay_status' => 'pending'
        ]);
        $this->assertFalse($this->invoice->canGenerateAbacatePayCharge());
    }

    /** @test */
    public function it_can_check_if_has_abacatepay_charge()
    {
        $this->assertFalse($this->invoice->hasAbacatePayCharge());

        $this->invoice->update([
            'abacatepay_billing_id' => 'ch_123',
            'abacatepay_status' => 'pending'
        ]);
        $this->assertTrue($this->invoice->hasAbacatePayCharge());
    }

    /** @test */
    public function it_can_check_if_abacatepay_is_paid()
    {
        $this->assertFalse($this->invoice->isAbacatePayPaid());

        $this->invoice->update([
            'abacatepay_billing_id' => 'ch_123',
            'abacatepay_status' => 'paid'
        ]);
        $this->assertTrue($this->invoice->isAbacatePayPaid());
    }

    /** @test */
    public function it_can_get_abacatepay_status_label()
    {
        $this->assertEquals('Não configurado', $this->invoice->abacate_pay_status);

        $this->invoice->update([
            'abacatepay_billing_id' => 'ch_123',
            'abacatepay_status' => 'pending'
        ]);
        $this->assertEquals('Pendente', $this->invoice->abacate_pay_status);

        $this->invoice->update(['abacatepay_status' => 'paid']);
        $this->assertEquals('Pago', $this->invoice->abacate_pay_status);

        $this->invoice->update(['abacatepay_status' => 'cancelled']);
        $this->assertEquals('Cancelado', $this->invoice->abacate_pay_status);
    }

    /** @test */
    public function it_can_get_abacatepay_status_color()
    {
        $this->assertEquals('danger', $this->invoice->abacate_pay_status_color);

        $this->invoice->update([
            'abacatepay_billing_id' => 'ch_123',
            'abacatepay_status' => 'pending'
        ]);
        $this->assertEquals('warning', $this->invoice->abacate_pay_status_color);

        $this->invoice->update(['abacatepay_status' => 'paid']);
        $this->assertEquals('success', $this->invoice->abacate_pay_status_color);

        $this->invoice->update(['abacatepay_status' => 'cancelled']);
        $this->assertEquals('danger', $this->invoice->abacate_pay_status_color);
    }

    /** @test */
    public function it_can_mark_as_paid()
    {
        $this->invoice->markAsPaid('pix', 'ch_123');

        $this->assertEquals('paid', $this->invoice->status);
        $this->assertEquals('pix', $this->invoice->payment_method);
        $this->assertEquals('ch_123', $this->invoice->abacatepay_billing_id);
        $this->assertEquals('paid', $this->invoice->abacatepay_status);
        $this->assertNotNull($this->invoice->paid_at);
    }
} 