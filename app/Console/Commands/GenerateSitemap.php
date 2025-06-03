<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Project;
use App\Models\Category;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml for Nice Designs';

    public function handle()
    {
        $this->info('🔍 Gerando sitemap.xml...');
        
        try {
            $sitemap = $this->buildSitemapXml();
            file_put_contents(public_path('sitemap.xml'), $sitemap);
            
            $urlCount = substr_count($sitemap, '<url>');
            $this->info("✅ Sitemap gerado com sucesso! ({$urlCount} URLs)");
            
        } catch (\Exception $e) {
            $this->error("❌ Erro ao gerar sitemap: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }

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
            $xml .= "    <lastmod>" . Carbon::now()->format('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>{$page['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$page['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        // Posts
        $posts = Post::where('status', 'published')->select('slug', 'updated_at')->get();
        foreach ($posts as $post) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}/blog/{$post->slug}</loc>\n";
            $xml .= "    <lastmod>" . $post->updated_at->format('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.6</priority>\n";
            $xml .= "  </url>\n";
        }

        // Projects
        $projects = Project::where('status', 'published')->select('slug', 'updated_at')->get();
        foreach ($projects as $project) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}/portfolio/{$project->slug}</loc>\n";
            $xml .= "    <lastmod>" . $project->updated_at->format('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.7</priority>\n";
            $xml .= "  </url>\n";
        }

        // Categories
        $categories = Category::select('slug', 'updated_at')->get();
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
} 