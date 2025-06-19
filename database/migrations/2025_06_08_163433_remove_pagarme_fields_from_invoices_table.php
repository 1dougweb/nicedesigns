<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Exception;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Verificar quais colunas existem
            $columns = Schema::getColumnListing('invoices');
            
            $pagarmeColumns = [
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
            ];
            
            // Remover índices primeiro (usando try/catch para evitar erros)
            $indicesToDrop = [
                ['pagarme_charge_id'],
                ['pagarme_transaction_id'],
                ['pagarme_status']
            ];
            
            foreach ($indicesToDrop as $indexColumns) {
                try {
                    if (in_array($indexColumns[0], $columns)) {
                        $table->dropIndex($indexColumns);
                    }
                } catch (Exception $e) {
                    // Índice pode não existir, continuar
                }
            }
            
            // Remover colunas que existem
            $columnsToRemove = [];
            foreach ($pagarmeColumns as $column) {
                if (in_array($column, $columns)) {
                    $columnsToRemove[] = $column;
                }
            }
            
            if (!empty($columnsToRemove)) {
                $table->dropColumn($columnsToRemove);
            }
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Verificar quais colunas já existem
            $columns = Schema::getColumnListing('invoices');
            
            // Recriar campos do PagarMe apenas se não existirem
            if (!in_array('pagarme_charge_id', $columns)) {
                $table->string('pagarme_charge_id')->nullable()->after('payment_notes')->comment('ID da cobrança no PagarMe');
            }
            
            if (!in_array('pagarme_transaction_id', $columns)) {
                $table->string('pagarme_transaction_id')->nullable()->after('pagarme_charge_id')->comment('ID da transação no PagarMe');
            }
            
            if (!in_array('pagarme_status', $columns)) {
                $table->string('pagarme_status')->nullable()->after('pagarme_transaction_id')->comment('Status atual no PagarMe');
            }
            
            if (!in_array('pagarme_data', $columns)) {
                $table->json('pagarme_data')->nullable()->after('pagarme_status')->comment('Dados completos da resposta PagarMe');
            }
            
            // URLs de pagamento
            if (!in_array('payment_url', $columns)) {
                $table->string('payment_url')->nullable()->after('pagarme_data')->comment('URL geral de pagamento');
            }
            
            if (!in_array('pix_qr_code', $columns)) {
                $table->text('pix_qr_code')->nullable()->after('payment_url')->comment('Código QR PIX');
            }
            
            if (!in_array('pix_qr_code_url', $columns)) {
                $table->string('pix_qr_code_url')->nullable()->after('pix_qr_code')->comment('URL da imagem QR PIX');
            }
            
            if (!in_array('boleto_url', $columns)) {
                $table->string('boleto_url')->nullable()->after('pix_qr_code_url')->comment('URL do boleto');
            }
            
            if (!in_array('boleto_barcode', $columns)) {
                $table->string('boleto_barcode')->nullable()->after('boleto_url')->comment('Código de barras do boleto');
            }
            
            // Controle de webhook
            if (!in_array('webhook_received_at', $columns)) {
                $table->timestamp('webhook_received_at')->nullable()->after('boleto_barcode')->comment('Última vez que recebeu webhook');
            }
            
            // Criar índices se as colunas existem
            try {
                if (in_array('pagarme_charge_id', $columns)) {
                    $table->index('pagarme_charge_id');
                }
            } catch (Exception $e) {
                // Índice pode já existir
            }
            
            try {
                if (in_array('pagarme_transaction_id', $columns)) {
                    $table->index('pagarme_transaction_id');
                }
            } catch (Exception $e) {
                // Índice pode já existir
            }
            
            try {
                if (in_array('pagarme_status', $columns)) {
                    $table->index('pagarme_status');
                }
            } catch (Exception $e) {
                // Índice pode já existir
            }
        });
    }
};
