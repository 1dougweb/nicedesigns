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
        Schema::table('users', function (Blueprint $table) {
            // Informações pessoais/empresariais
            $table->string('full_name')->nullable()->after('name');
            $table->enum('person_type', ['fisica', 'juridica'])->default('fisica')->after('full_name');
            $table->string('document')->nullable()->after('person_type'); // CPF ou CNPJ
            $table->string('phone')->nullable()->after('document');
            $table->string('whatsapp')->nullable()->after('phone');
            
            // Endereço
            $table->string('zip_code')->nullable()->after('whatsapp');
            $table->string('address')->nullable()->after('zip_code');
            $table->string('address_number')->nullable()->after('address');
            $table->string('address_complement')->nullable()->after('address_number');
            $table->string('neighborhood')->nullable()->after('address_complement');
            $table->string('city')->nullable()->after('neighborhood');
            $table->string('state')->nullable()->after('city');
            $table->string('country')->default('Brasil')->after('state');
            
            // Informações profissionais
            $table->string('company_name')->nullable()->after('country');
            $table->string('position')->nullable()->after('company_name');
            $table->text('bio')->nullable()->after('position');
            
            // Avatar e preferências
            $table->string('avatar')->nullable()->after('bio');
            $table->json('preferences')->nullable()->after('avatar');
            
            // Timestamps de perfil
            $table->timestamp('profile_completed_at')->nullable()->after('preferences');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'full_name', 'person_type', 'document', 'phone', 'whatsapp',
                'zip_code', 'address', 'address_number', 'address_complement', 
                'neighborhood', 'city', 'state', 'country',
                'company_name', 'position', 'bio', 'avatar', 'preferences',
                'profile_completed_at'
            ]);
        });
    }
};
