<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Para SQLite, precisamos recriar a tabela com o novo enum
        if (DB::getDriverName() === 'sqlite') {
            // Criar tabela temporária
            Schema::create('client_projects_temp', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null');
                
                $table->string('name');
                $table->text('description')->nullable();
                $table->text('requirements')->nullable();
                $table->decimal('budget', 10, 2)->nullable();
                $table->string('currency', 3)->default('BRL');
                
                $table->enum('status', [
                    'planejamento', 'aguardando_aprovacao', 'em_andamento', 'pausado', 
                    'aguardando_cliente', 'em_revisao', 'concluido', 'cancelado'
                ])->default('planejamento');
                $table->integer('progress_percentage')->default(0);
                
                $table->json('stages')->nullable();
                $table->string('current_stage')->nullable();
                
                $table->json('technologies')->nullable();
                $table->json('tags')->nullable();
                
                $table->date('start_date')->nullable();
                $table->date('estimated_completion')->nullable();
                $table->date('actual_completion')->nullable();
                $table->date('deadline')->nullable();
                
                $table->string('preview_url')->nullable();
                $table->string('live_url')->nullable();
                $table->string('repository_url')->nullable();
                $table->json('files')->nullable();
                
                $table->text('contract_details')->nullable();
                $table->enum('priority', ['baixa', 'normal', 'alta', 'urgente'])->default('normal');
                
                $table->text('last_update')->nullable();
                $table->timestamp('last_activity_at')->nullable();
                
                $table->integer('rating')->nullable();
                $table->text('client_feedback')->nullable();
                
                $table->timestamps();
                
                $table->index(['user_id', 'status']);
                $table->index(['status', 'created_at']);
            });

            // Copiar dados se existirem
            if (Schema::hasTable('client_projects')) {
                DB::statement('INSERT INTO client_projects_temp SELECT * FROM client_projects');
                Schema::drop('client_projects');
            }

            // Renomear tabela temporária
            Schema::rename('client_projects_temp', 'client_projects');
        } else {
            // Para outros bancos, usar ALTER TABLE
            DB::statement("ALTER TABLE client_projects MODIFY COLUMN status ENUM('planejamento', 'aguardando_aprovacao', 'em_andamento', 'pausado', 'aguardando_cliente', 'em_revisao', 'concluido', 'cancelado') DEFAULT 'planejamento'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverter para o enum original
        if (DB::getDriverName() === 'sqlite') {
            Schema::create('client_projects_temp', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null');
                
                $table->string('name');
                $table->text('description')->nullable();
                $table->text('requirements')->nullable();
                $table->decimal('budget', 10, 2)->nullable();
                $table->string('currency', 3)->default('BRL');
                
                $table->enum('status', [
                    'aguardando_aprovacao', 'em_andamento', 'pausado', 
                    'aguardando_cliente', 'em_revisao', 'concluido', 'cancelado'
                ])->default('aguardando_aprovacao');
                $table->integer('progress_percentage')->default(0);
                
                $table->json('stages')->nullable();
                $table->string('current_stage')->nullable();
                
                $table->json('technologies')->nullable();
                $table->json('tags')->nullable();
                
                $table->date('start_date')->nullable();
                $table->date('estimated_completion')->nullable();
                $table->date('actual_completion')->nullable();
                $table->date('deadline')->nullable();
                
                $table->string('preview_url')->nullable();
                $table->string('live_url')->nullable();
                $table->string('repository_url')->nullable();
                $table->json('files')->nullable();
                
                $table->text('contract_details')->nullable();
                $table->enum('priority', ['baixa', 'normal', 'alta', 'urgente'])->default('normal');
                
                $table->text('last_update')->nullable();
                $table->timestamp('last_activity_at')->nullable();
                
                $table->integer('rating')->nullable();
                $table->text('client_feedback')->nullable();
                
                $table->timestamps();
                
                $table->index(['user_id', 'status']);
                $table->index(['status', 'created_at']);
            });

            DB::statement('INSERT INTO client_projects_temp SELECT * FROM client_projects');
            Schema::drop('client_projects');
            Schema::rename('client_projects_temp', 'client_projects');
        } else {
            DB::statement("ALTER TABLE client_projects MODIFY COLUMN status ENUM('aguardando_aprovacao', 'em_andamento', 'pausado', 'aguardando_cliente', 'em_revisao', 'concluido', 'cancelado') DEFAULT 'aguardando_aprovacao'");
        }
    }
};
