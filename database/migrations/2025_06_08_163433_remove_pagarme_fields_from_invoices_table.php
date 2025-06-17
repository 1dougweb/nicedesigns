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
            // Remover índices primeiro
            $table->dropIndex(['pagarme_charge_id']);
            $table->dropIndex(['pagarme_transaction_id']);
            $table->dropIndex(['pagarme_status']);
            
            // Remover campos do PagarMe
            $table->dropColumn([
                'pagarme_charge_id',
                'pagarme_transaction_id',
                'pagarme_status',
                'pagarme_data',
                'pix_qr_code',
                'pix_qr_code_url',
                'boleto_url',
                'boleto_barcode',
                'payment_url',
                'webhook_received_at'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Recriar campos do PagarMe
            $table->string('pagarme_charge_id')->nullable()->after('payment_notes')->comment('ID da cobrança no PagarMe');
            $table->string('pagarme_transaction_id')->nullable()->after('pagarme_charge_id')->comment('ID da transação no PagarMe');
            $table->string('pagarme_status')->nullable()->after('pagarme_transaction_id')->comment('Status atual no PagarMe');
            $table->json('pagarme_data')->nullable()->after('pagarme_status')->comment('Dados completos da resposta PagarMe');
            
            // URLs de pagamento
            $table->string('payment_url')->nullable()->after('pagarme_data')->comment('URL geral de pagamento');
            $table->text('pix_qr_code')->nullable()->after('payment_url')->comment('Código QR PIX');
            $table->string('pix_qr_code_url')->nullable()->after('pix_qr_code')->comment('URL da imagem QR PIX');
            $table->string('boleto_url')->nullable()->after('pix_qr_code_url')->comment('URL do boleto');
            $table->string('boleto_barcode')->nullable()->after('boleto_url')->comment('Código de barras do boleto');
            
            // Controle de webhook
            $table->timestamp('webhook_received_at')->nullable()->after('boleto_barcode')->comment('Última vez que recebeu webhook');
            
            // Índices
            $table->index('pagarme_charge_id');
            $table->index('pagarme_transaction_id');
            $table->index('pagarme_status');
        });
    }
};
