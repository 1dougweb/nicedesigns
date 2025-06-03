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
            // Campos principais do PagarMe
            $table->string('pagarme_charge_id')->nullable()->after('payment_notes')->comment('ID da cobrança no PagarMe');
            $table->string('pagarme_transaction_id')->nullable()->after('pagarme_charge_id')->comment('ID da transação no PagarMe');
            $table->string('pagarme_status')->nullable()->after('pagarme_transaction_id')->comment('Status atual no PagarMe');
            $table->json('pagarme_data')->nullable()->after('pagarme_status')->comment('Dados completos da resposta PagarMe');
            
            // URLs e códigos de pagamento
            $table->string('payment_url')->nullable()->after('pagarme_data')->comment('URL geral de pagamento');
            $table->string('boleto_url')->nullable()->after('payment_url')->comment('URL do boleto');
            $table->string('boleto_barcode')->nullable()->after('boleto_url')->comment('Código de barras do boleto');
            $table->text('pix_qr_code')->nullable()->after('boleto_barcode')->comment('QR Code do PIX');
            $table->text('pix_code')->nullable()->after('pix_qr_code')->comment('Código PIX copia e cola');
            
            // Sistema de cobrança automática
            $table->boolean('auto_charge_enabled')->default(false)->after('pix_code')->comment('Cobrança automática habilitada');
            $table->date('auto_charge_date')->nullable()->after('auto_charge_enabled')->comment('Data para gerar cobrança automaticamente');
            
            // Controle de webhooks
            $table->timestamp('webhook_received_at')->nullable()->after('auto_charge_date')->comment('Última atualização via webhook');
            
            // Índices para performance
            $table->index('pagarme_charge_id');
            $table->index('pagarme_transaction_id');
            $table->index('pagarme_status');
            $table->index(['auto_charge_enabled', 'auto_charge_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Remover índices primeiro
            $table->dropIndex(['pagarme_charge_id']);
            $table->dropIndex(['pagarme_transaction_id']);
            $table->dropIndex(['pagarme_status']);
            $table->dropIndex(['auto_charge_enabled', 'auto_charge_date']);
            
            // Remover colunas
            $table->dropColumn([
                'pagarme_charge_id',
                'pagarme_transaction_id',
                'pagarme_status',
                'pagarme_data',
                'payment_url',
                'boleto_url',
                'boleto_barcode',
                'pix_qr_code',
                'pix_code',
                'auto_charge_enabled',
                'auto_charge_date',
                'webhook_received_at',
            ]);
        });
    }
};
