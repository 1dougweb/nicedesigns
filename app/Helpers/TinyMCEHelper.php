<?php

namespace App\Helpers;

use App\Models\Setting;

class TinyMCEHelper
{
    /**
     * Get TinyMCE configuration from database settings
     */
    public static function getConfig(): array
    {
        $settings = Setting::where('group', 'editor')->pluck('value', 'key');
        
        return [
            'api_key' => $settings['tinymce_api_key'] ?? '',
            'height' => (int) ($settings['tinymce_height'] ?? 400),
            'plugins' => $settings['tinymce_plugins'] ?? 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
            'toolbar' => $settings['tinymce_toolbar'] ?? 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            'content_css' => $settings['tinymce_content_css'] ?? '',
            'enable_upload' => ($settings['tinymce_enable_upload'] ?? '0') === '1',
            'upload_path' => $settings['tinymce_upload_path'] ?? 'uploads/editor',
            'max_file_size' => (int) ($settings['tinymce_max_file_size'] ?? 5),
            'allowed_extensions' => explode(',', $settings['tinymce_allowed_extensions'] ?? 'jpg,jpeg,png,gif,webp'),
        ];
    }

    /**
     * Generate TinyMCE JavaScript configuration
     */
    public static function getJSConfig(string $selector = '.tinymce-editor'): string
    {
        $config = self::getConfig();
        
        if (empty($config['api_key'])) {
            return '';
        }

        $jsConfig = [
            'selector' => $selector,
            'height' => $config['height'],
            'plugins' => $config['plugins'],
            'toolbar' => $config['toolbar'],
            'menubar' => false,
            'branding' => false,
            'promotion' => false,
            'language' => 'pt_BR',
            'skin' => 'oxide-dark',
            'content_css' => 'dark',
            'content_style' => '
                body { 
                    font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
                    font-size: 14px; 
                    line-height: 1.6;
                    color: #e5e7eb;
                    background-color: #1f2937;
                    margin: 1rem;
                }
                h1, h2, h3, h4, h5, h6 { 
                    color: #f9fafb; 
                    font-weight: 600;
                    margin-top: 1.5rem;
                    margin-bottom: 0.5rem;
                }
                h1 { font-size: 2rem; }
                h2 { font-size: 1.5rem; }
                h3 { font-size: 1.25rem; }
                p { margin-bottom: 1rem; }
                a { color: #60a5fa; text-decoration: underline; }
                a:hover { color: #93c5fd; }
                blockquote { 
                    border-left: 4px solid #374151; 
                    padding-left: 1rem; 
                    margin: 1rem 0; 
                    font-style: italic;
                    color: #9ca3af;
                }
                code { 
                    background-color: #374151; 
                    color: #f59e0b; 
                    padding: 0.125rem 0.25rem; 
                    border-radius: 0.25rem; 
                    font-family: "JetBrains Mono", "Fira Code", monospace;
                }
                pre { 
                    background-color: #111827; 
                    color: #e5e7eb; 
                    padding: 1rem; 
                    border-radius: 0.5rem; 
                    overflow-x: auto;
                    border: 1px solid #374151;
                }
                table { 
                    border-collapse: collapse; 
                    width: 100%; 
                    margin: 1rem 0;
                }
                th, td { 
                    border: 1px solid #374151; 
                    padding: 0.5rem; 
                    text-align: left; 
                }
                th { 
                    background-color: #374151; 
                    font-weight: 600;
                    color: #f9fafb;
                }
                ul, ol { margin: 1rem 0; padding-left: 2rem; }
                li { margin-bottom: 0.25rem; }
                img { 
                    max-width: 100%; 
                    height: auto; 
                    border-radius: 0.5rem;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
                }
                hr { 
                    border: none; 
                    border-top: 1px solid #374151; 
                    margin: 2rem 0; 
                }
            ',
        ];

        // Add custom CSS if provided
        if (!empty($config['content_css'])) {
            $jsConfig['content_style'] .= ' ' . $config['content_css'];
        }

        // Add image upload configuration if enabled
        if ($config['enable_upload']) {
            $jsConfig['images_upload_url'] = route('admin.tinymce.upload');
            $jsConfig['images_upload_handler'] = 'tinymce_upload_handler';
            $jsConfig['automatic_uploads'] = true;
            $jsConfig['file_picker_types'] = 'image';
        }

        return 'tinymce.init(' . json_encode($jsConfig, JSON_UNESCAPED_SLASHES) . ');';
    }

    /**
     * Generate TinyMCE script tag
     */
    public static function getScriptTag(string $selector = '.tinymce-editor'): string
    {
        $config = self::getConfig();
        
        if (empty($config['api_key'])) {
            return '<!-- TinyMCE: API Key não configurada -->';
        }

        $jsConfig = self::getJSConfig($selector);
        
        return '
        <script src="https://cdn.tiny.cloud/1/' . $config['api_key'] . '/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            ' . $jsConfig . '
            
            // Custom upload handler
            function tinymce_upload_handler(blobInfo, success, failure, progress) {
                const xhr = new XMLHttpRequest();
                const formData = new FormData();
                
                xhr.withCredentials = false;
                xhr.open("POST", "' . route('admin.tinymce.upload') . '");
                
                xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector("meta[name=csrf-token]").getAttribute("content"));
                
                xhr.upload.onprogress = function (e) {
                    progress(e.loaded / e.total * 100);
                };
                
                xhr.onload = function() {
                    if (xhr.status === 403) {
                        failure("HTTP Error: " + xhr.status, { remove: true });
                        return;
                    }
                    
                    if (xhr.status < 200 || xhr.status >= 300) {
                        failure("HTTP Error: " + xhr.status);
                        return;
                    }
                    
                    const json = JSON.parse(xhr.responseText);
                    
                    if (!json || typeof json.location != "string") {
                        failure("Invalid JSON: " + xhr.responseText);
                        return;
                    }
                    
                    success(json.location);
                };
                
                xhr.onerror = function () {
                    failure("Image upload failed due to a XHR Transport error. Code: " + xhr.status);
                };
                
                formData.append("file", blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            }
        </script>';
    }

    /**
     * Check if TinyMCE is properly configured
     */
    public static function isConfigured(): bool
    {
        $config = self::getConfig();
        return !empty($config['api_key']);
    }

    /**
     * Get upload directory path
     */
    public static function getUploadPath(): string
    {
        $config = self::getConfig();
        return public_path($config['upload_path']);
    }

    /**
     * Get upload URL
     */
    public static function getUploadUrl(): string
    {
        $config = self::getConfig();
        return url($config['upload_path']);
    }

    /**
     * Validate uploaded file
     */
    public static function validateUpload($file): array
    {
        $config = self::getConfig();
        
        if (!$file || !$file->isValid()) {
            return ['error' => 'Arquivo inválido'];
        }

        // Check file size
        $maxSize = $config['max_file_size'] * 1024 * 1024; // Convert MB to bytes
        if ($file->getSize() > $maxSize) {
            return ['error' => 'Arquivo muito grande. Máximo: ' . $config['max_file_size'] . 'MB'];
        }

        // Check file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $config['allowed_extensions'])) {
            return ['error' => 'Extensão não permitida. Permitidas: ' . implode(', ', $config['allowed_extensions'])];
        }

        return ['success' => true];
    }
} 