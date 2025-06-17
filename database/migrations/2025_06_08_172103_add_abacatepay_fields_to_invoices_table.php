<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Campos principais do AbacatePay
            $table->string('abacatepay_billing_id')->nullable()->index();
            $table->string('abacatepay_customer_id')->nullable();
            $table->string('abacatepay_status')->nullable();
            $table->json('abacatepay_data')->nullable();
            
            // URLs de pagamento
            $table->text('payment_url')->nullable();
            
            // PIX
            $table->text('pix_qr_code')->nullable();
            $table->string('pix_qr_code_url')->nullable();
            
            // Boleto
            $table->string('boleto_url')->nullable();
            $table->string('boleto_barcode')->nullable();
            
            // Webhook
            $table->timestamp('webhook_received_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'abacatepay_billing_id',
                'abacatepay_customer_id',
                'abacatepay_status',
                'abacatepay_data',
                'payment_url',
                'pix_qr_code',
                'pix_qr_code_url',
                'boleto_url',
                'boleto_barcode',
                'webhook_received_at'
            ]);
        });
    }
};
