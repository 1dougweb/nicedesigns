<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\TinyMCEHelper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TinyMCEController extends Controller
{
    /**
     * Handle image upload for TinyMCE editor
     */
    public function upload(Request $request): JsonResponse
    {
        try {
            // Check if TinyMCE is configured
            if (!TinyMCEHelper::isConfigured()) {
                return response()->json([
                    'error' => 'TinyMCE não está configurado'
                ], 400);
            }

            // Check if file was uploaded
            if (!$request->hasFile('file')) {
                return response()->json([
                    'error' => 'Nenhum arquivo enviado'
                ], 400);
            }

            $file = $request->file('file');
            
            // Validate file
            $validation = TinyMCEHelper::validateUpload($file);
            if (isset($validation['error'])) {
                return response()->json([
                    'error' => $validation['error']
                ], 400);
            }

            // Get upload configuration
            $config = TinyMCEHelper::getConfig();
            $uploadPath = $config['upload_path'];

            // Ensure upload directory exists
            $fullUploadPath = public_path($uploadPath);
            if (!is_dir($fullUploadPath)) {
                mkdir($fullUploadPath, 0755, true);
            }

            // Generate unique filename
            $extension = $file->getClientOriginalExtension();
            $filename = Str::uuid() . '.' . $extension;

            // Move file to upload directory
            $file->move($fullUploadPath, $filename);

            // Return the URL for TinyMCE
            $fileUrl = url($uploadPath . '/' . $filename);

            return response()->json([
                'location' => $fileUrl
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno do servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete uploaded image
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $url = $request->input('url');
            
            if (!$url) {
                return response()->json([
                    'error' => 'URL não fornecida'
                ], 400);
            }

            // Extract filename from URL
            $config = TinyMCEHelper::getConfig();
            $uploadPath = $config['upload_path'];
            $baseUrl = url($uploadPath . '/');
            
            if (strpos($url, $baseUrl) !== 0) {
                return response()->json([
                    'error' => 'URL inválida'
                ], 400);
            }

            $filename = str_replace($baseUrl, '', $url);
            $filePath = public_path($uploadPath . '/' . $filename);

            if (file_exists($filePath)) {
                unlink($filePath);
                return response()->json([
                    'success' => true,
                    'message' => 'Arquivo deletado com sucesso'
                ]);
            }

            return response()->json([
                'error' => 'Arquivo não encontrado'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno do servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * List uploaded images
     */
    public function list(): JsonResponse
    {
        try {
            $config = TinyMCEHelper::getConfig();
            $uploadPath = $config['upload_path'];
            $fullUploadPath = public_path($uploadPath);

            if (!is_dir($fullUploadPath)) {
                return response()->json([
                    'images' => []
                ]);
            }

            $images = [];
            $files = scandir($fullUploadPath);

            foreach ($files as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                $filePath = $fullUploadPath . '/' . $file;
                if (is_file($filePath)) {
                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    
                    if (in_array($extension, $config['allowed_extensions'])) {
                        $images[] = [
                            'name' => $file,
                            'url' => url($uploadPath . '/' . $file),
                            'size' => filesize($filePath),
                            'modified' => filemtime($filePath)
                        ];
                    }
                }
            }

            // Sort by modification time (newest first)
            usort($images, function($a, $b) {
                return $b['modified'] - $a['modified'];
            });

            return response()->json([
                'images' => $images
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno do servidor: ' . $e->getMessage()
            ], 500);
        }
    }
} 