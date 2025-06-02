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

        // Criar usuário admin
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@nicedesigns.com.br',
            'password' => Hash::make('password'),
        ]);

        // Criar categorias
        $webDesign = Category::create([
            'name' => 'Web Design',
            'slug' => 'web-design',
            'description' => 'Projetos de design para web',
            'is_active' => true,
        ]);

        $desenvolvimento = Category::create([
            'name' => 'Desenvolvimento',
            'slug' => 'desenvolvimento',
            'description' => 'Projetos de desenvolvimento web',
            'is_active' => true,
        ]);

        $marketing = Category::create([
            'name' => 'Marketing Digital',
            'slug' => 'marketing-digital',
            'description' => 'Estratégias de marketing digital',
            'is_active' => true,
        ]);

        // Criar posts de exemplo
        Post::create([
            'title' => 'Como criar um site moderno em 2025',
            'slug' => 'como-criar-site-moderno-2025',
            'content' => 'Conteúdo completo sobre como criar sites modernos...',
            'excerpt' => 'Aprenda as melhores práticas para criar sites modernos e responsivos.',
            'meta_title' => 'Como criar um site moderno em 2025',
            'meta_description' => 'Guia completo para criar sites modernos e responsivos em 2025.',
            'is_published' => true,
            'published_at' => now(),
            'category_id' => $desenvolvimento->id,
            'user_id' => $admin->id,
        ]);

        // Criar projetos de exemplo
        Project::create([
            'title' => 'E-commerce Moderno',
            'slug' => 'ecommerce-moderno',
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
        ]);

        // Criar páginas estáticas
        Page::create([
            'title' => 'Sobre Nós',
            'slug' => 'sobre',
            'content' => 'Somos uma agência especializada em web design...',
            'meta_title' => 'Sobre Nós - Nice Designs',
            'meta_description' => 'Conheça a Nice Designs, agência especializada em web design.',
            'is_published' => true,
            'user_id' => $admin->id,
        ]);

        Page::create([
            'title' => 'Nossos Serviços',
            'slug' => 'servicos',
            'content' => 'Oferecemos serviços completos de web design...',
            'meta_title' => 'Nossos Serviços - Nice Designs',
            'meta_description' => 'Conheça todos os serviços oferecidos pela Nice Designs.',
            'is_published' => true,
            'user_id' => $admin->id,
        ]);

        // Configurações básicas
        Setting::set('site_name', 'Nice Designs', 'string', 'general');
        Setting::set('site_description', 'Agência de Web Design Moderna', 'string', 'general');
        Setting::set('contact_email', 'contato@nicedesigns.com', 'string', 'contact');
        Setting::set('contact_phone', '(11) 99999-9999', 'string', 'contact');
        Setting::set('address', 'São Paulo, SP', 'string', 'contact');
    }
}
