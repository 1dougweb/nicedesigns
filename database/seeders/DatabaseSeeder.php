<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Project;
use App\Models\Page;
use App\Models\Setting;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Criar usuário admin (apenas se não existir) e garantir role admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@nicedesigns.com.br'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]
        );

        // Criar categorias (apenas se não existirem)
        $webDesign = Category::firstOrCreate(
            ['slug' => 'web-design'],
            [
                'name' => 'Web Design',
                'description' => 'Projetos de design para web',
                'is_active' => true,
            ]
        );

        $desenvolvimento = Category::firstOrCreate(
            ['slug' => 'desenvolvimento'],
            [
                'name' => 'Desenvolvimento',
                'description' => 'Projetos de desenvolvimento web',
                'is_active' => true,
            ]
        );

        $marketing = Category::firstOrCreate(
            ['slug' => 'marketing-digital'],
            [
                'name' => 'Marketing Digital',
                'description' => 'Estratégias de marketing digital',
                'is_active' => true,
            ]
        );

        // Criar posts de exemplo (apenas se não existirem)
        Post::firstOrCreate(
            ['slug' => 'como-criar-site-moderno-2025'],
            [
                'title' => 'Como criar um site moderno em 2025',
                'content' => 'Conteúdo completo sobre como criar sites modernos...',
                'excerpt' => 'Aprenda as melhores práticas para criar sites modernos e responsivos.',
                'meta_title' => 'Como criar um site moderno em 2025',
                'meta_description' => 'Guia completo para criar sites modernos e responsivos em 2025.',
                'is_published' => true,
                'published_at' => now(),
                'category_id' => $desenvolvimento->id,
                'user_id' => $admin->id,
            ]
        );

        // Criar projetos de exemplo (apenas se não existirem)
        Project::firstOrCreate(
            ['slug' => 'ecommerce-moderno'],
            [
                'title' => 'E-commerce Moderno',
                'description' => 'Desenvolvimento de e-commerce completo com design moderno',
                'content' => 'Projeto completo de e-commerce...',
                'client_name' => 'Empresa XYZ',
                'project_url' => 'https://exemplo.com',
                'technologies' => ['Laravel', 'Vue.js', 'Tailwind CSS'],
                'completion_date' => now()->subDays(30),
                'is_featured' => true,
                'is_published' => true,
                'category_id' => $desenvolvimento->id,
                'user_id' => $admin->id,
            ]
        );

        // Criar páginas estáticas (apenas se não existirem)
        Page::firstOrCreate(
            ['slug' => 'sobre'],
            [
                'title' => 'Sobre Nós',
                'content' => 'Somos uma agência especializada em web design...',
                'meta_title' => 'Sobre Nós - Nice Designs',
                'meta_description' => 'Conheça a Nice Designs, agência especializada em web design.',
                'is_published' => true,
                'user_id' => $admin->id,
            ]
        );

        Page::firstOrCreate(
            ['slug' => 'servicos'],
            [
                'title' => 'Nossos Serviços',
                'content' => 'Oferecemos serviços completos de web design...',
                'meta_title' => 'Nossos Serviços - Nice Designs',
                'meta_description' => 'Conheça todos os serviços oferecidos pela Nice Designs.',
                'is_published' => true,
                'user_id' => $admin->id,
            ]
        );

        // Configurações completas organizadas por grupos
        
        // Grupo: Geral
        Setting::set('site_name', 'Nice Designs', 'string', 'general');
        Setting::set('site_description', 'Agência de Web Design Moderna - Criamos experiências digitais excepcionais', 'string', 'general');
        Setting::set('site_keywords', 'web design, desenvolvimento web, ui/ux, agência digital', 'string', 'general');
        Setting::set('site_logo', 'https://via.placeholder.com/200x60/3B82F6/FFFFFF?text=NICE+DESIGNS', 'string', 'general');
        Setting::set('site_favicon', 'https://via.placeholder.com/32x32/3B82F6/FFFFFF?text=ND', 'string', 'general');
        Setting::set('maintenance_mode', false, 'boolean', 'general');
        Setting::set('allow_registration', false, 'boolean', 'general');
        Setting::set('posts_per_page', 12, 'integer', 'general');
        Setting::set('projects_per_page', 9, 'integer', 'general');
        Setting::set('timezone', 'America/Sao_Paulo', 'string', 'general');
        Setting::set('date_format', 'd/m/Y', 'string', 'general');
        Setting::set('currency', 'BRL', 'string', 'general');

        // Grupo: Contato
        Setting::set('contact_email', 'contato@nicedesigns.com.br', 'string', 'contact');
        Setting::set('contact_phone', '(11) 99999-9999', 'string', 'contact');
        Setting::set('contact_whatsapp', '5511999999999', 'string', 'contact');
        Setting::set('address', 'Rua das Flores, 123', 'string', 'contact');
        Setting::set('address_complement', 'Sala 456', 'string', 'contact');
        Setting::set('city', 'São Paulo', 'string', 'contact');
        Setting::set('state', 'SP', 'string', 'contact');
        Setting::set('zip_code', '01234-567', 'string', 'contact');
        Setting::set('country', 'Brasil', 'string', 'contact');

        // Grupo: Redes Sociais
        Setting::set('facebook_url', 'https://facebook.com/nicedesigns', 'string', 'social');
        Setting::set('instagram_url', 'https://instagram.com/nicedesigns', 'string', 'social');
        Setting::set('twitter_url', '', 'string', 'social');
        Setting::set('linkedin_url', 'https://linkedin.com/company/nicedesigns', 'string', 'social');
        Setting::set('youtube_url', '', 'string', 'social');
        Setting::set('github_url', 'https://github.com/nicedesigns', 'string', 'social');
        Setting::set('behance_url', 'https://behance.net/nicedesigns', 'string', 'social');
        Setting::set('dribbble_url', 'https://dribbble.com/nicedesigns', 'string', 'social');

        // Grupo: SEO
        Setting::set('meta_title', 'Nice Designs - Agência de Web Design', 'string', 'seo');
        Setting::set('meta_description', 'Criamos experiências digitais excepcionais. Web design moderno, desenvolvimento responsivo e estratégias digitais eficazes.', 'string', 'seo');
        Setting::set('google_analytics_id', '', 'string', 'seo');
        Setting::set('google_search_console', '', 'text', 'seo');
        Setting::set('facebook_pixel_id', '', 'string', 'seo');

        // Grupo: Email
        Setting::set('smtp_host', 'smtp.gmail.com', 'string', 'email');
        Setting::set('smtp_port', 587, 'integer', 'email');
        Setting::set('smtp_username', '', 'string', 'email');
        Setting::set('smtp_password', '', 'string', 'email');
        Setting::set('smtp_encryption', 'tls', 'string', 'email');
        Setting::set('mail_from_address', 'noreply@nicedesigns.com.br', 'string', 'email');
        Setting::set('mail_from_name', 'Nice Designs', 'string', 'email');

        // Grupo: Aparência
        Setting::set('primary_color', '#3B82F6', 'string', 'appearance');
        Setting::set('secondary_color', '#1F2937', 'string', 'appearance');
        Setting::set('accent_color', '#10B981', 'string', 'appearance');
        Setting::set('custom_css', '', 'text', 'appearance');
        Setting::set('custom_js', '', 'text', 'appearance');
    }
}
