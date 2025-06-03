<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;

class SettingController extends Controller
{
    /**
     * Display the settings page
     */
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the settings
     */
    public function update(Request $request)
    {
        // Validação simplificada para debug
        $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:50',
            'zip_code' => 'required|string|max:10',
            'country' => 'required|string|max:50',
            'posts_per_page' => 'required|integer|min:1|max:50',
            'projects_per_page' => 'required|integer|min:1|max:50',
            'timezone' => 'required|string',
            'date_format' => 'required|string',
            'currency' => 'required|string|max:10',
        ]);

        try {
            \Log::info('Iniciando salvamento de configurações', [
                'user_id' => auth()->id(),
                'request_data' => $request->all()
            ]);

            // Contar configurações antes
            $settingsCountBefore = Setting::count();
            \Log::info('Configurações antes do salvamento: ' . $settingsCountBefore);

            // Salvar configurações por grupo
            $this->saveSettingsGroup($request, 'general', [
                'site_name', 'site_description', 'site_keywords', 'site_logo', 
                'site_favicon', 'maintenance_mode', 'allow_registration', 
                'posts_per_page', 'projects_per_page', 'timezone', 'date_format', 
                'currency'
            ]);

            $this->saveSettingsGroup($request, 'contact', [
                'contact_email', 'contact_phone', 'contact_whatsapp', 'address',
                'address_complement', 'city', 'state', 'zip_code', 'country'
            ]);

            $this->saveSettingsGroup($request, 'social', [
                'facebook_url', 'instagram_url', 'twitter_url', 'linkedin_url',
                'youtube_url', 'github_url', 'behance_url', 'dribbble_url'
            ]);

            $this->saveSettingsGroup($request, 'seo', [
                'meta_title', 'meta_description', 'google_analytics_id',
                'google_search_console', 'facebook_pixel_id'
            ]);

            $this->saveSettingsGroup($request, 'email', [
                'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password',
                'smtp_encryption', 'mail_from_address', 'mail_from_name'
            ]);

            $this->saveSettingsGroup($request, 'appearance', [
                'primary_color', 'secondary_color', 'accent_color', 
                'custom_css', 'custom_js'
            ]);

            // Contar configurações depois
            $settingsCountAfter = Setting::count();
            \Log::info('Configurações após o salvamento: ' . $settingsCountAfter);

            // Limpar cache de configurações
            Artisan::call('config:clear');
            Artisan::call('view:clear');

            \Log::info('Configurações salvas com sucesso');

            return Redirect::route('admin.settings.index')
                ->with('success', 'Configurações atualizadas com sucesso!');
                
        } catch (\Exception $e) {
            \Log::error('Erro ao salvar configurações: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return Redirect::route('admin.settings.index')
                ->with('error', 'Erro ao salvar configurações: ' . $e->getMessage());
        }
    }

    /**
     * Save settings for a specific group
     */
    private function saveSettingsGroup(Request $request, string $group, array $keys): void
    {
        foreach ($keys as $key) {
            $value = $request->input($key);
            $type = $this->getSettingType($key, $value);
            
            // Para checkboxes, verificar se foi enviado
            if ($type === 'boolean') {
                $value = $request->has($key) ? true : false;
            }
            
            // Para valores nulos em strings, usar string vazia
            if ($type === 'string' && is_null($value)) {
                $value = '';
            }
            
            Setting::set($key, $value, $type, $group);
        }
    }

    /**
     * Determine the setting type based on key and value
     */
    private function getSettingType(string $key, mixed $value): string
    {
        // Boolean settings
        if (in_array($key, ['maintenance_mode', 'allow_registration'])) {
            return 'boolean';
        }
        
        // Integer settings
        if (in_array($key, ['posts_per_page', 'projects_per_page', 'smtp_port'])) {
            return 'integer';
        }
        
        // Text/Textarea settings
        if (in_array($key, ['custom_css', 'custom_js', 'google_search_console'])) {
            return 'text';
        }
        
        return 'string';
    }

    /**
     * Test email configuration
     */
    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email'
        ]);

        try {
            // Configurar temporariamente as configurações de email das settings
            $this->updateEmailConfig();
            
            // Enviar email de teste
            \Mail::to($request->test_email)->send(new \App\Mail\TestEmail());
            
            return response()->json([
                'success' => true,
                'message' => 'Email de teste enviado com sucesso para ' . $request->test_email
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update email configuration from settings
     */
    private function updateEmailConfig()
    {
        $emailSettings = Setting::where('group', 'email')->get()->keyBy('key');
        
        if ($emailSettings->isNotEmpty()) {
            // Configurar o mail config temporariamente
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => $emailSettings->get('smtp_host')->value ?? 'smtp.gmail.com',
                'mail.mailers.smtp.port' => $emailSettings->get('smtp_port')->value ?? 587,
                'mail.mailers.smtp.username' => $emailSettings->get('smtp_username')->value ?? '',
                'mail.mailers.smtp.password' => $emailSettings->get('smtp_password')->value ?? '',
                'mail.mailers.smtp.encryption' => $emailSettings->get('smtp_encryption')->value ?? 'tls',
                'mail.from.address' => $emailSettings->get('mail_from_address')->value ?? 'noreply@nicedesigns.com.br',
                'mail.from.name' => $emailSettings->get('mail_from_name')->value ?? 'Nice Designs',
            ]);
        }
    }

    /**
     * Clear cache
     */
    public function clearCache()
    {
        try {
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            Artisan::call('cache:clear');
            
            return response()->json([
                'success' => true,
                'message' => 'Cache limpo com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao limpar cache: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display SEO management page
     */
    public function seoIndex()
    {
        $robotsContent = $this->getRobotsContent();
        $sitemapExists = file_exists(public_path('sitemap.xml'));
        $sitemapLastGenerated = $sitemapExists ? 
            \Carbon\Carbon::createFromTimestamp(filemtime(public_path('sitemap.xml')))->format('d/m/Y H:i') 
            : 'Nunca';
        
        $urlCounts = [
            'pages' => 5,
            'posts' => \App\Models\Post::where('status', 'published')->count(),
            'projects' => \App\Models\Project::where('status', 'published')->count(),
            'categories' => \App\Models\Category::count(),
        ];
        
        return view('admin.seo.index', compact('robotsContent', 'sitemapExists', 'sitemapLastGenerated', 'urlCounts'));
    }

    /**
     * Generate sitemap.xml
     */
    public function generateSitemap()
    {
        try {
            $sitemap = $this->buildSitemapXml();
            file_put_contents(public_path('sitemap.xml'), $sitemap);
            
            return response()->json([
                'success' => true,
                'message' => 'Sitemap gerado com sucesso!',
                'timestamp' => \Carbon\Carbon::now()->format('d/m/Y H:i')
            ]);
        } catch (\Exception $e) {
            \Log::error('Erro ao gerar sitemap: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erro ao gerar sitemap: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update robots.txt
     */
    public function updateRobots(Request $request)
    {
        $request->validate(['robots_content' => 'required|string']);

        try {
            file_put_contents(public_path('robots.txt'), $request->robots_content);
            
            return response()->json([
                'success' => true,
                'message' => 'Robots.txt atualizado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar robots.txt: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset robots.txt to default
     */
    public function resetRobots()
    {
        try {
            $defaultRobots = $this->getDefaultRobotsContent();
            file_put_contents(public_path('robots.txt'), $defaultRobots);
            
            return response()->json([
                'success' => true,
                'message' => 'Robots.txt restaurado!',
                'content' => $defaultRobots
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao restaurar robots.txt: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Build sitemap XML content
     */
    private function buildSitemapXml(): string
    {
        $baseUrl = config('app.url');
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Static pages
        $staticPages = [
            ['url' => '/', 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['url' => '/sobre', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/contato', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => '/blog', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => '/portfolio', 'priority' => '0.9', 'changefreq' => 'weekly'],
        ];

        foreach ($staticPages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}{$page['url']}</loc>\n";
            $xml .= "    <lastmod>" . \Carbon\Carbon::now()->format('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>{$page['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$page['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        // Blog posts
        $posts = \App\Models\Post::where('status', 'published')
            ->select('slug', 'updated_at')
            ->get();

        foreach ($posts as $post) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}/blog/{$post->slug}</loc>\n";
            $xml .= "    <lastmod>" . $post->updated_at->format('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.6</priority>\n";
            $xml .= "  </url>\n";
        }

        // Portfolio projects
        $projects = \App\Models\Project::where('status', 'published')
            ->select('slug', 'updated_at')
            ->get();

        foreach ($projects as $project) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}/portfolio/{$project->slug}</loc>\n";
            $xml .= "    <lastmod>" . $project->updated_at->format('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.7</priority>\n";
            $xml .= "  </url>\n";
        }

        // Categories
        $categories = \App\Models\Category::select('slug', 'updated_at')->get();

        foreach ($categories as $category) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}/blog/categoria/{$category->slug}</loc>\n";
            $xml .= "    <lastmod>" . $category->updated_at->format('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.5</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';
        return $xml;
    }

    /**
     * Get current robots.txt content
     */
    private function getRobotsContent(): string
    {
        $robotsPath = public_path('robots.txt');
        
        if (file_exists($robotsPath)) {
            return file_get_contents($robotsPath);
        }
        
        return $this->getDefaultRobotsContent();
    }

    /**
     * Get default robots.txt content
     */
    private function getDefaultRobotsContent(): string
    {
        $baseUrl = config('app.url');
        
        return "User-agent: *\n" .
               "Disallow: /admin/\n" .
               "Disallow: /client/\n" .
               "Disallow: /api/\n" .
               "Disallow: /vendor/\n" .
               "Disallow: /storage/\n" .
               "Disallow: /bootstrap/\n" .
               "Allow: /\n" .
               "\n" .
               "# Sitemap\n" .
               "Sitemap: {$baseUrl}/sitemap.xml\n";
    }
}
