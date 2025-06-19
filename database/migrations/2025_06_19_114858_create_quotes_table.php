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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Cliente
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Admin que criou
            $table->string('title');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->decimal('budget', 10, 2);
            $table->string('currency', 3)->default('BRL');
            $table->enum('status', ['pendente', 'aceito', 'rejeitado', 'expirado', 'cancelado'])->default('pendente');
            $table->json('services')->nullable(); // Lista de serviços incluídos
            $table->json('deliverables')->nullable(); // Lista de entregáveis
            $table->json('payment_terms')->nullable(); // Termos de pagamento
            $table->integer('timeline')->nullable(); // Prazo em dias
            $table->date('valid_until')->nullable(); // Data de validade
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('admin_notes')->nullable(); // Notas internas
            $table->text('client_notes')->nullable(); // Notas do cliente
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['status', 'valid_until']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
