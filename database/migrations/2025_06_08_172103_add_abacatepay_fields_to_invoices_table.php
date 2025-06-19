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
            // Verificar quais colunas já existem
            $columns = Schema::getColumnListing('invoices');
            
            // Campos principais do AbacatePay
            if (!in_array('abacatepay_billing_id', $columns)) {
                $table->string('abacatepay_billing_id')->nullable()->index();
            }
            if (!in_array('abacatepay_customer_id', $columns)) {
                $table->string('abacatepay_customer_id')->nullable();
            }
            if (!in_array('abacatepay_status', $columns)) {
                $table->string('abacatepay_status')->nullable();
            }
            if (!in_array('abacatepay_data', $columns)) {
                $table->json('abacatepay_data')->nullable();
            }
            
            // URLs de pagamento
            if (!in_array('payment_url', $columns)) {
                $table->text('payment_url')->nullable();
            }
            
            // PIX
            if (!in_array('pix_qr_code', $columns)) {
                $table->text('pix_qr_code')->nullable();
            }
            if (!in_array('pix_qr_code_url', $columns)) {
                $table->string('pix_qr_code_url')->nullable();
            }
            
            // Boleto
            if (!in_array('boleto_url', $columns)) {
                $table->string('boleto_url')->nullable();
            }
            if (!in_array('boleto_barcode', $columns)) {
                $table->string('boleto_barcode')->nullable();
            }
            
            // Webhook
            if (!in_array('webhook_received_at', $columns)) {
                $table->timestamp('webhook_received_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $columns = Schema::getColumnListing('invoices');
            $columnsToRemove = [];
            
            $abacateColumns = [
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
            ];
            
            foreach ($abacateColumns as $column) {
                if (in_array($column, $columns)) {
                    $columnsToRemove[] = $column;
                }
            }
            
            if (!empty($columnsToRemove)) {
                $table->dropColumn($columnsToRemove);
            }
        });
    }
};
