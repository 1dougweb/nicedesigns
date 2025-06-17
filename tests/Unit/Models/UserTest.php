<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'client'
        ]);
    }

    /** @test */
    public function it_can_check_if_user_is_admin()
    {
        $this->assertFalse($this->user->isAdmin());

        $this->user->update(['role' => 'admin']);
        $this->assertTrue($this->user->isAdmin());
    }

    /** @test */
    public function it_can_check_if_user_is_client()
    {
        $this->assertTrue($this->user->isClient());

        $this->user->update(['role' => 'admin']);
        $this->assertFalse($this->user->isClient());
    }

    /** @test */
    public function it_can_get_user_full_name()
    {
        $this->assertEquals('John Doe', $this->user->full_name);
    }

    /** @test */
    public function it_can_get_user_abacatepay_data()
    {
        $this->user->update([
            'abacatepay_customer_id' => 'cus_123',
            'abacatepay_token' => 'token_123'
        ]);

        $this->assertEquals('cus_123', $this->user->abacatepay_customer_id);
        $this->assertEquals('token_123', $this->user->abacatepay_token);
    }

    /** @test */
    public function it_can_check_if_user_has_abacatepay_data()
    {
        $this->assertFalse($this->user->hasAbacatePayData());

        $this->user->update([
            'abacatepay_customer_id' => 'cus_123',
            'abacatepay_token' => 'token_123'
        ]);

        $this->assertTrue($this->user->hasAbacatePayData());
    }

    /** @test */
    public function it_can_get_user_abacatepay_status()
    {
        $this->assertEquals('Não configurado', $this->user->abacate_pay_status);

        $this->user->update([
            'abacatepay_customer_id' => 'cus_123',
            'abacatepay_token' => 'token_123'
        ]);

        $this->assertEquals('Configurado', $this->user->abacate_pay_status);
    }

    /** @test */
    public function it_can_get_user_abacatepay_status_color()
    {
        $this->assertEquals('danger', $this->user->abacate_pay_status_color);

        $this->user->update([
            'abacatepay_customer_id' => 'cus_123',
            'abacatepay_token' => 'token_123'
        ]);

        $this->assertEquals('success', $this->user->abacate_pay_status_color);
    }
} 