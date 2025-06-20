@props([
    'name' => 'content',
    'id' => null,
    'value' => '',
    'height' => null,
    'required' => false,
    'placeholder' => 'Digite seu conteúdo aqui...',
    'class' => '',
])

@php
    $editorId = $id ?? 'tinymce-' . $name;
    $editorClass = 'tinymce-editor w-full bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 ' . $class;
@endphp

<div class="tinymce-wrapper">
    <textarea 
        name="{{ $name }}" 
        id="{{ $editorId }}"
        class="{{ $editorClass }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->except(['name', 'id', 'value', 'height', 'required', 'placeholder', 'class']) }}
    >{{ old($name, $value) }}</textarea>
</div>

@push('scripts')
{!! \App\Helpers\TinyMCEHelper::getScriptTag('#' . $editorId) !!}
@endpush

@if(!\App\Helpers\TinyMCEHelper::isConfigured())
    <div class="mt-4 p-4 bg-yellow-500/10 border border-yellow-500/30 rounded-xl backdrop-blur-sm">
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <i class="fi fi-rr-exclamation text-yellow-400 text-xl mt-1"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-yellow-300 mb-1">
                    Editor TinyMCE não configurado
                </h3>
                <p class="text-sm text-yellow-200/80 leading-relaxed">
                    Para usar o editor de texto avançado, configure a API Key do TinyMCE nas 
                    <a href="{{ route('admin.settings.index') }}" class="font-medium text-yellow-300 hover:text-yellow-200 underline transition-colors">
                        configurações do sistema
                    </a>.
                </p>
                <div class="mt-3">
                    <a href="https://www.tiny.cloud/" target="_blank" class="inline-flex items-center space-x-2 text-xs text-yellow-300/70 hover:text-yellow-300 transition-colors">
                        <i class="fi fi-rr-link text-xs"></i>
                        <span>Obter API Key gratuita</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif 