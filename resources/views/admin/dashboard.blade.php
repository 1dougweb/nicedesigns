@extends('layouts.app')

@section('title', '- Dashboard Admin')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Bem-vindo, {{ auth()->user()->name }}!</span>
                    <a href="{{ route('home') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Ver Site
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        
        <!-- Navigation Menu -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Menu Administrativo</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    
                    <a href="{{ route('admin.posts.index') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition group">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-700 transition">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </div>
                        <span class="mt-2 text-sm font-medium text-gray-900">Posts</span>
                    </a>

                    <a href="{{ route('admin.projects.index') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition group">
                        <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center group-hover:bg-green-700 transition">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <span class="mt-2 text-sm font-medium text-gray-900">Projetos</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition group">
                        <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center group-hover:bg-purple-700 transition">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <span class="mt-2 text-sm font-medium text-gray-900">Categorias</span>
                    </a>

                    <a href="{{ route('admin.contacts.index') }}" class="flex flex-col items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition group">
                        <div class="w-8 h-8 bg-yellow-600 rounded-lg flex items-center justify-center group-hover:bg-yellow-700 transition">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="mt-2 text-sm font-medium text-gray-900">Contatos</span>
                        @if($stats['contacts']['new'] > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">
                                {{ $stats['contacts']['new'] }} novos
                            </span>
                        @endif
                    </a>

                    <div class="flex flex-col items-center p-4 bg-gray-50 rounded-lg opacity-50">
                        <div class="w-8 h-8 bg-gray-400 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="mt-2 text-sm font-medium text-gray-500">Páginas</span>
                        <span class="text-xs text-gray-400 mt-1">Em breve</span>
                    </div>

                    <div class="flex flex-col items-center p-4 bg-gray-50 rounded-lg opacity-50">
                        <div class="w-8 h-8 bg-gray-400 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <span class="mt-2 text-sm font-medium text-gray-500">Configurações</span>
                        <span class="text-xs text-gray-400 mt-1">Em breve</span>
                    </div>

                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            
            <!-- Posts Stats -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Posts</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $stats['posts']['total'] }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex text-sm text-gray-600">
                            <span class="flex items-center">
                                <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                                {{ $stats['posts']['published'] }} publicados
                            </span>
                            <span class="flex items-center ml-4">
                                <span class="w-2 h-2 bg-gray-400 rounded-full mr-1"></span>
                                {{ $stats['posts']['drafts'] }} rascunhos
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Projects Stats -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Projetos</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $stats['projects']['total'] }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex text-sm text-gray-600">
                            <span class="flex items-center">
                                <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                                {{ $stats['projects']['published'] }} publicados
                            </span>
                            <span class="flex items-center ml-4">
                                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-1"></span>
                                {{ $stats['projects']['featured'] }} destaques
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contacts Stats -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-600 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Contatos</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $stats['contacts']['total'] }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex text-sm text-gray-600">
                            <span class="flex items-center">
                                <span class="w-2 h-2 bg-red-400 rounded-full mr-1"></span>
                                {{ $stats['contacts']['new'] }} novos
                            </span>
                            <span class="flex items-center ml-4">
                                <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                                {{ $stats['contacts']['completed'] }} concluídos
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories Stats -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Categorias</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $stats['categories'] }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm text-gray-600">
                            Organizando conteúdo
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Recent Posts -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Posts Recentes</h3>
                        <a href="{{ route('admin.posts.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Ver todos</a>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentPosts as $post)
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900">{{ $post->title }}</h4>
                                <div class="mt-1 flex items-center text-sm text-gray-500">
                                    <span class="truncate">{{ $post->category->name }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                @if($post->is_published)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Publicado
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Rascunho
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-gray-500">
                        Nenhum post encontrado.
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Contacts -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Contatos Recentes</h3>
                        <a href="{{ route('admin.contacts.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Ver todos</a>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentContacts as $contact)
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900">{{ $contact->name }}</h4>
                                <div class="mt-1 text-sm text-gray-500">
                                    <p class="truncate">{{ $contact->subject }}</p>
                                    <p class="text-xs">{{ $contact->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="ml-4">
                                @if($contact->status === 'new')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Novo
                                    </span>
                                @elseif($contact->status === 'in_progress')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Em andamento
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Concluído
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-gray-500">
                        Nenhum contato encontrado.
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
        
    </div>
</div>
@endsection 