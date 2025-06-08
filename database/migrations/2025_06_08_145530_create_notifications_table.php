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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('info'); // info, success, warning, error, new_contact, etc.
            $table->string('icon')->nullable(); // ícone personalizado
            $table->string('color')->nullable(); // cor personalizada
            $table->string('url')->nullable(); // URL para redirecionamento
            $table->json('data')->nullable(); // dados adicionais
            $table->timestamp('read_at')->nullable(); // quando foi lida
            $table->timestamp('expires_at')->nullable(); // quando expira
            $table->timestamps();

            // Índices para melhor performance
            $table->index(['user_id', 'read_at']);
            $table->index(['user_id', 'type']);
            $table->index(['user_id', 'created_at']);
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
