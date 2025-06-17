@extends('layouts.admin')

@section('title', '- Analytics de Tickets')
@section('page-title', 'Analytics de Support Tickets')

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white mb-2">Analytics de Support Tickets</h2>
        <p class="text-gray-400">Métricas de performance e insights do suporte ao cliente</p>
    </div>
    <div class="flex space-x-4">
        <a href="{{ route('admin.support-tickets.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors">
           <i class="fi fi-rr-arrow-small-left text-white text-2xl mt-2 mr-2"></i>
            Voltar
        </a>
        <button onclick="exportReport()" 
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105">
                <i class="fi fi-rr-file-xls text-white text-2xl mt-2 mr-2"></i>
            Exportar Relatório
        </button>
    </div>
</div>

<!-- Summary Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Tickets -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-sm font-medium">Total de Tickets</p>
                <p class="text-3xl font-bold text-white">{{ number_format($analytics['total_tickets']) }}</p>
                <p class="text-green-400 text-sm mt-1">
                    +{{ $analytics['tickets_this_month'] }} este mês
                </p>
            </div>
            <div class="p-3 bg-blue-500/20 rounded-xl">
            <i class="fi fi-rr-document text-blue-400 text-2xl mt-2"></i>
            </div>
        </div>
    </div>

    <!-- Resolution Rate -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-sm font-medium">Taxa de Resolução</p>
                <p class="text-3xl font-bold text-white">{{ number_format($analytics['resolution_rate'], 1) }}%</p>
                <p class="text-green-400 text-sm mt-1">
                    {{ $analytics['resolved_tickets'] }} resolvidos
                </p>
            </div>
            <div class="p-3 bg-green-500/20 rounded-xl">
            <i class="fi fi-rr-comment-check text-green-400 text-2xl mt-2"></i>
            </div>
        </div>
    </div>

    <!-- Average Response Time -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-sm font-medium">Tempo Médio de Resposta</p>
                <p class="text-3xl font-bold text-white">{{ $analytics['avg_response_time'] }}h</p>
                <p class="text-yellow-400 text-sm mt-1">
                    Meta: ≤ 24h
                </p>
            </div>
            <div class="p-3 bg-yellow-500/20 rounded-xl">
            <i class="fi fi-rr-pending text-yellow-400 text-2xl mt-2"></i>    
            </div>
        </div>
    </div>

    <!-- Satisfaction Score -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-sm font-medium">Satisfação do Cliente</p>
                <p class="text-3xl font-bold text-white">{{ number_format($analytics['satisfaction_score'], 1) }}/5</p>
                <p class="text-purple-400 text-sm mt-1">
                    {{ $analytics['total_ratings'] }} avaliações
                </p>
            </div>
            <div class="p-3 bg-purple-500/20 rounded-xl">
            <i class="fi fi-rr-star text-purple-400 text-2xl mt-2"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Tickets by Status -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6">Tickets por Status</h3>
        <div class="space-y-4">
            @foreach($analytics['status_distribution'] as $status => $count)
                @php
                    $percentage = $analytics['total_tickets'] > 0 ? ($count / $analytics['total_tickets']) * 100 : 0;
                    $statusColors = [
                        'aberto' => 'blue',
                        'em_andamento' => 'yellow',
                        'aguardando_resposta' => 'orange',
                        'resolvido' => 'green',
                        'fechado' => 'gray'
                    ];
                    $color = $statusColors[$status] ?? 'gray';
                @endphp
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-{{ $color }}-500 rounded-full mr-3"></div>
                        <span class="text-gray-300">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-white font-medium">{{ $count }}</span>
                        <span class="text-gray-400 text-sm">{{ number_format($percentage, 1) }}%</span>
                    </div>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-{{ $color }}-500 h-2 rounded-full transition-all duration-300" 
                         style="width: {{ $percentage }}%"></div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Tickets by Priority -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6">Tickets por Prioridade</h3>
        <div class="space-y-4">
            @foreach($analytics['priority_distribution'] as $priority => $count)
                @php
                    $percentage = $analytics['total_tickets'] > 0 ? ($count / $analytics['total_tickets']) * 100 : 0;
                    $priorityColors = [
                        'baixa' => 'green',
                        'normal' => 'blue',
                        'alta' => 'yellow',
                        'urgente' => 'red'
                    ];
                    $color = $priorityColors[$priority] ?? 'gray';
                @endphp
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-{{ $color }}-500 rounded-full mr-3"></div>
                        <span class="text-gray-300">{{ ucfirst($priority) }}</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-white font-medium">{{ $count }}</span>
                        <span class="text-gray-400 text-sm">{{ number_format($percentage, 1) }}%</span>
                    </div>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-{{ $color }}-500 h-2 rounded-full transition-all duration-300" 
                         style="width: {{ $percentage }}%"></div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Monthly Trends -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8 mb-8">
    <h3 class="text-xl font-bold text-white mb-6">Tendências Mensais (Últimos 6 Meses)</h3>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($analytics['monthly_trends'] as $month => $data)
            <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                <p class="text-gray-400 text-sm">{{ $month }}</p>
                <p class="text-2xl font-bold text-white">{{ $data['total'] }}</p>
                <p class="text-green-400 text-xs">{{ $data['resolved'] }} resolvidos</p>
                <div class="w-full bg-gray-700 rounded-full h-1 mt-2">
                    @php
                        $resolvedPercentage = $data['total'] > 0 ? ($data['resolved'] / $data['total']) * 100 : 0;
                    @endphp
                    <div class="bg-green-500 h-1 rounded-full" style="width: {{ $resolvedPercentage }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Detailed Analytics -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Top Categories -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6">Principais Categorias</h3>
        <div class="space-y-4">
            @foreach($analytics['category_distribution'] as $category => $count)
                @php
                    $percentage = $analytics['total_tickets'] > 0 ? ($count / $analytics['total_tickets']) * 100 : 0;
                @endphp
                <div class="flex items-center justify-between">
                    <span class="text-gray-300">{{ ucfirst($category) }}</span>
                    <div class="flex items-center space-x-3">
                        <span class="text-white font-medium">{{ $count }}</span>
                        <span class="text-gray-400 text-sm">{{ number_format($percentage, 1) }}%</span>
                    </div>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-purple-500 h-2 rounded-full transition-all duration-300" 
                         style="width: {{ $percentage }}%"></div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6">Métricas de Performance</h3>
        <div class="space-y-6">
            <!-- SLA Compliance -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-300">Cumprimento SLA</span>
                    <span class="text-white font-bold">{{ number_format($analytics['sla_compliance'], 1) }}%</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-3">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-3 rounded-full transition-all duration-300" 
                         style="width: {{ $analytics['sla_compliance'] }}%"></div>
                </div>
            </div>

            <!-- Average First Response -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-300">Tempo Primeira Resposta</span>
                    <span class="text-white font-bold">{{ $analytics['avg_first_response'] }}h</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-3">
                    @php
                        $responsePercentage = min(($analytics['avg_first_response'] / 24) * 100, 100);
                    @endphp
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-3 rounded-full transition-all duration-300" 
                         style="width: {{ $responsePercentage }}%"></div>
                </div>
            </div>

            <!-- Average Resolution Time -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-300">Tempo Médio Resolução</span>
                    <span class="text-white font-bold">{{ $analytics['avg_resolution_time'] }}h</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-3">
                    @php
                        $resolutionPercentage = min(($analytics['avg_resolution_time'] / 72) * 100, 100);
                    @endphp
                    <div class="bg-gradient-to-r from-yellow-500 to-orange-500 h-3 rounded-full transition-all duration-300" 
                         style="width: {{ $resolutionPercentage }}%"></div>
                </div>
            </div>

            <!-- Customer Satisfaction -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-300">Satisfação Cliente</span>
                    <span class="text-white font-bold">{{ number_format($analytics['satisfaction_score'], 1) }}/5</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-3">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-3 rounded-full transition-all duration-300" 
                         style="width: {{ ($analytics['satisfaction_score'] / 5) * 100 }}%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Agent Performance -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Agent Performance Table -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6">Performance dos Agentes</h3>
        <div class="space-y-4">
            @foreach($analytics['agent_performance'] as $agent)
                <div class="flex items-center justify-between p-4 bg-gray-700/30 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-sm">{{ substr($agent['name'], 0, 2) }}</span>
                        </div>
                        <div>
                            <p class="text-white font-medium">{{ $agent['name'] }}</p>
                            <p class="text-gray-400 text-sm">{{ $agent['total_tickets'] }} tickets</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-emerald-400 font-bold">{{ $agent['resolution_rate'] }}%</p>
                        <p class="text-gray-400 text-sm">{{ $agent['avg_response_time'] }}h média</p>
                        <div class="flex items-center mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-3 h-3 {{ $i <= $agent['satisfaction'] ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            @endfor
                            <span class="text-gray-400 text-xs ml-1">{{ $agent['satisfaction'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6">Atividade Recente</h3>
        <div class="space-y-4">
            @foreach($analytics['recent_activity'] as $activity)
                <div class="flex items-start space-x-4 p-4 bg-gray-700/30 rounded-xl">
                    <div class="w-2 h-2 bg-cyan-400 rounded-full mt-2 flex-shrink-0"></div>
                    <div class="flex-1">
                        <p class="text-white text-sm">{{ $activity['description'] }}</p>
                        <p class="text-gray-400 text-xs mt-1">{{ $activity['created_at']->diffForHumans() }}</p>
                        @if(isset($activity['subject']))
                            <p class="text-gray-400 text-xs">"{{ Str::limit($activity['subject'], 50) }}"</p>
                        @endif
                    </div>
                    @if(isset($activity['ticket_id']))
                        <a href="{{ route('admin.support-tickets.show', $activity['ticket_id']) }}" 
                           class="text-cyan-400 hover:text-cyan-300 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Additional Insights -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
    <h3 class="text-xl font-bold text-white mb-6">Insights e Recomendações</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Insight 1 -->
        <div class="p-6 bg-blue-500/10 border border-blue-500/30 rounded-xl">
            <div class="flex items-center mb-4">
            <i class="fi fi-rr-comment-info text-blue-400 text-2xl mt-2 mr-3"></i>
                <h4 class="text-blue-400 font-bold">Performance</h4>
            </div>
            <p class="text-gray-300 text-sm leading-relaxed">
                O tempo médio de resposta está {{ $analytics['avg_response_time'] <= 24 ? 'dentro' : 'acima' }} da meta de 24h. 
                @if($analytics['avg_response_time'] > 24)
                    Considere redistribuir a carga de trabalho entre a equipe.
                @else
                    Excelente performance da equipe!
                @endif
            </p>
        </div>

        <!-- Insight 2 -->
        <div class="p-6 bg-green-500/10 border border-green-500/30 rounded-xl">
            <div class="flex items-center mb-4">
            <i class="fi fi-rr-comment-check text-green-400 text-2xl mt-2 mr-3"></i>
                <h4 class="text-green-400 font-bold">Resolução</h4>
            </div>
            <p class="text-gray-300 text-sm leading-relaxed">
                Taxa de resolução de {{ number_format($analytics['resolution_rate'], 1) }}% 
                {{ $analytics['resolution_rate'] >= 80 ? 'está excelente' : 'pode ser melhorada' }}. 
                @if($analytics['resolution_rate'] < 80)
                    Foque em melhorar a qualidade das primeiras respostas.
                @endif
            </p>
        </div>

        <!-- Insight 3 -->
        <div class="p-6 bg-purple-500/10 border border-purple-500/30 rounded-xl">
            <div class="flex items-center mb-4">
            <i class="fi fi-rr-star text-purple-400 text-2xl mt-2 mr-3"></i>
                <h4 class="text-purple-400 font-bold">Satisfação</h4>
            </div>
            <p class="text-gray-300 text-sm leading-relaxed">
                Satisfação média de {{ number_format($analytics['satisfaction_score'], 1) }}/5 
                {{ $analytics['satisfaction_score'] >= 4 ? 'é excelente' : 'pode ser melhorada' }}. 
                @if($analytics['satisfaction_score'] < 4)
                    Implemente pesquisas de feedback mais detalhadas.
                @endif
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportReport() {
    window.open('/admin/support-tickets/analytics/export', '_blank');
}

// Chart.js integration could be added here for more advanced charts
</script>
@endpush 