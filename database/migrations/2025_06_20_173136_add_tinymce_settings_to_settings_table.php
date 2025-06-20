<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Adicionar configurações padrão do TinyMCE
        $editorSettings = [
            [
                'key' => 'tinymce_api_key',
                'value' => '',
                'group' => 'editor',
                'type' => 'string',
                'description' => 'API Key do TinyMCE para editor de texto avançado'
            ],
            [
                'key' => 'tinymce_plugins',
                'value' => 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
                'group' => 'editor',
                'type' => 'string',
                'description' => 'Plugins ativos do TinyMCE'
            ],
            [
                'key' => 'tinymce_toolbar',
                'value' => 'undo redo | blocks fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | blockquote codesample | searchreplace | fullscreen preview | removeformat help',
                'group' => 'editor',
                'type' => 'string',
                'description' => 'Configuração da barra de ferramentas do TinyMCE'
            ],
            [
                'key' => 'tinymce_height',
                'value' => '400',
                'group' => 'editor',
                'type' => 'integer',
                'description' => 'Altura padrão do editor TinyMCE em pixels'
            ],
            [
                'key' => 'tinymce_content_css',
                'value' => '',
                'group' => 'editor',
                'type' => 'string',
                'description' => 'CSS personalizado para o conteúdo do editor'
            ],
            [
                'key' => 'tinymce_enable_upload',
                'value' => '1',
                'group' => 'editor',
                'type' => 'boolean',
                'description' => 'Permitir upload de imagens no editor'
            ],
            [
                'key' => 'tinymce_upload_path',
                'value' => 'uploads/editor',
                'group' => 'editor',
                'type' => 'string',
                'description' => 'Diretório para upload de imagens do editor'
            ],
            [
                'key' => 'tinymce_max_file_size',
                'value' => '5',
                'group' => 'editor',
                'type' => 'integer',
                'description' => 'Tamanho máximo de arquivo em MB para upload'
            ],
            [
                'key' => 'tinymce_allowed_extensions',
                'value' => 'jpg,jpeg,png,gif,webp',
                'group' => 'editor',
                'type' => 'string',
                'description' => 'Extensões de arquivo permitidas para upload'
            ]
        ];

        foreach ($editorSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remover configurações do TinyMCE
        $keys = [
            'tinymce_api_key',
            'tinymce_plugins',
            'tinymce_toolbar',
            'tinymce_height',
            'tinymce_content_css',
            'tinymce_enable_upload',
            'tinymce_upload_path',
            'tinymce_max_file_size',
            'tinymce_allowed_extensions'
        ];

        Setting::whereIn('key', $keys)->delete();
    }
};
