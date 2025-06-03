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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Cliente
            $table->foreignId('client_project_id')->nullable()->constrained()->onDelete('set null'); // Projeto relacionado
            
            // Informações da fatura
            $table->string('invoice_number')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            
            // Valores
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0); // Porcentagem
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('currency', 3)->default('BRL');
            
            // Status e datas
            $table->enum('status', ['pendente', 'paga', 'vencida', 'cancelada', 'parcial'])->default('pendente');
            $table->date('issue_date');
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            
            // Informações de pagamento
            $table->enum('payment_method', ['pix', 'boleto', 'transferencia', 'cartao', 'outro'])->nullable();
            $table->string('payment_reference')->nullable(); // Referência do pagamento
            $table->text('payment_notes')->nullable();
            
            // Arquivos
            $table->string('pdf_path')->nullable();
            $table->json('attachments')->nullable();
            
            // Observações
            $table->text('notes')->nullable();
            $table->text('payment_instructions')->nullable();
            
            $table->timestamps();
            
            // Índices
            $table->index(['user_id', 'status']);
            $table->index(['status', 'due_date']);
            $table->index('invoice_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
