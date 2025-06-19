<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposta de Orçamento - {{ $quote->title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            background: #fff;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }

        .company-logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .company-tagline {
            font-size: 14px;
            opacity: 0.9;
        }

        .quote-title {
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0 10px 0;
        }

        .quote-number {
            font-size: 14px;
            opacity: 0.8;
        }

        .content {
            padding: 0 30px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #667eea;
        }

        .client-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: bold;
            width: 30%;
            color: #555;
        }

        .info-value {
            width: 70%;
        }

        .quote-summary {
            background: #667eea;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 25px;
        }

        .summary-amount {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .summary-label {
            font-size: 14px;
            opacity: 0.9;
        }

        .summary-details {
            margin-top: 15px;
            display: flex;
            justify-content: space-around;
            font-size: 11px;
        }

        .list-item {
            background: #f8f9fa;
            padding: 10px 15px;
            margin-bottom: 8px;
            border-radius: 5px;
            border-left: 4px solid #667eea;
        }

        .description-text {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            white-space: pre-line;
        }

        .payment-terms {
            background: #e8f5e8;
            border: 1px solid #28a745;
            border-radius: 8px;
            padding: 15px;
        }

        .payment-term {
            margin-bottom: 8px;
            padding-left: 15px;
            position: relative;
        }

        .payment-term:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
        }

        .validity-info {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }

        .footer {
            margin-top: 40px;
            padding: 20px 30px;
            border-top: 2px solid #667eea;
            text-align: center;
            font-size: 11px;
            color: #666;
        }

        .contact-info {
            margin-top: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-accepted {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .two-column {
            display: flex;
            gap: 20px;
        }

        .column {
            flex: 1;
        }

        .page-break {
            page-break-before: always;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="company-logo">{{ site_setting('name') ?? config('app.name', 'Nice Designs') }}</div>
        <div class="company-tagline">{{ site_setting('tagline') ?? 'Transformando ideias em realidade digital' }}</div>
        
        <div class="quote-title">{{ $quote->title }}</div>
        <div class="quote-number">Proposta #{{ str_pad($quote->id, 4, '0', STR_PAD_LEFT) }}</div>
    </div>

    <div class="content">
        <!-- Quote Summary -->
        <div class="quote-summary">
            <div class="summary-amount">{{ $quote->formatted_total_amount }}</div>
            <div class="summary-label">Valor Total da Proposta</div>
            <div class="summary-details">
                @if($quote->timeline)
                    <div>Prazo: {{ $quote->timeline }} dias</div>
                @endif
                @if($quote->valid_until)
                    <div>Válido até: {{ $quote->valid_until->format('d/m/Y') }}</div>
                @endif
                <div>Status: 
                    <span class="status-badge status-{{ $quote->status }}">
                        {{ $quote->status_label }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Client Information -->
        <div class="section">
            <h2 class="section-title">Informações do Cliente</h2>
            <div class="client-info">
                <div class="info-row">
                    <div class="info-label">Nome:</div>
                    <div class="info-value">{{ $quote->user->display_name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $quote->user->email }}</div>
                </div>
                @if($quote->user->phone)
                    <div class="info-row">
                        <div class="info-label">Telefone:</div>
                        <div class="info-value">{{ $quote->user->formatted_phone }}</div>
                    </div>
                @endif
                @if($quote->user->company_name)
                    <div class="info-row">
                        <div class="info-label">Empresa:</div>
                        <div class="info-value">{{ $quote->user->company_name }}</div>
                    </div>
                @endif
                <div class="info-row">
                    <div class="info-label">Data da Proposta:</div>
                    <div class="info-value">{{ $quote->created_at->format('d/m/Y \à\s H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- Project Description -->
        <div class="section">
            <h2 class="section-title">Descrição do Projeto</h2>
            <div class="description-text">{{ $quote->description }}</div>
        </div>

        <!-- Requirements -->
        @if($quote->requirements)
            <div class="section">
                <h2 class="section-title">Requisitos Específicos</h2>
                <div class="description-text">{{ $quote->requirements }}</div>
            </div>
        @endif

        <!-- Services -->
        @if($quote->services && count($quote->services) > 0)
            <div class="section">
                <h2 class="section-title">Serviços Incluídos</h2>
                @foreach($quote->services as $service)
                    <div class="list-item">{{ $service }}</div>
                @endforeach
            </div>
        @endif

        <!-- Deliverables -->
        @if($quote->deliverables && count($quote->deliverables) > 0)
            <div class="section">
                <h2 class="section-title">Entregáveis</h2>
                @foreach($quote->deliverables as $deliverable)
                    <div class="list-item">{{ $deliverable }}</div>
                @endforeach
            </div>
        @endif

        <!-- Payment Terms -->
        @if($quote->payment_terms && count($quote->payment_terms) > 0)
            <div class="section">
                <h2 class="section-title">Termos de Pagamento</h2>
                <div class="payment-terms">
                    @foreach($quote->payment_terms as $term)
                        <div class="payment-term">{{ $term }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Budget Breakdown -->
        <div class="section">
            <h2 class="section-title">Detalhamento do Investimento</h2>
            <div class="client-info">
                <div class="info-row">
                    <div class="info-label">Valor Base:</div>
                    <div class="info-value">{{ $quote->formatted_budget }}</div>
                </div>
                @if($quote->discount_amount)
                    <div class="info-row">
                        <div class="info-label">Desconto:</div>
                        <div class="info-value">- R$ {{ number_format($quote->discount_amount, 2, ',', '.') }}</div>
                    </div>
                @elseif($quote->discount_percentage)
                    <div class="info-row">
                        <div class="info-label">Desconto ({{ $quote->discount_percentage }}%):</div>
                        <div class="info-value">- R$ {{ number_format($quote->budget * ($quote->discount_percentage / 100), 2, ',', '.') }}</div>
                    </div>
                @endif
                <div class="info-row" style="border-top: 1px solid #ddd; padding-top: 10px; margin-top: 10px; font-weight: bold; font-size: 14px;">
                    <div class="info-label">TOTAL:</div>
                    <div class="info-value">{{ $quote->formatted_total_amount }}</div>
                </div>
            </div>
        </div>

        <!-- Validity -->
        @if($quote->valid_until)
            <div class="section">
                <div class="validity-info">
                    <strong>⏰ Validade da Proposta</strong><br>
                    Esta proposta é válida até <strong>{{ $quote->valid_until->format('d/m/Y') }}</strong>.<br>
                    Após essa data, os valores e condições poderão ser revisados.
                </div>
            </div>
        @endif

        <!-- Notes -->
        @if($quote->admin_notes)
            <div class="section">
                <h2 class="section-title">Observações Importantes</h2>
                <div class="description-text">{{ $quote->admin_notes }}</div>
            </div>
        @endif

        @if($quote->client_notes)
            <div class="section">
                <h2 class="section-title">Comentários do Cliente</h2>
                <div class="description-text">{{ $quote->client_notes }}</div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <div><strong>{{ site_setting('name') ?? config('app.name', 'Nice Designs') }}</strong></div>
        <div class="contact-info">
            @if(site_setting('email'))
                Email: {{ site_setting('email') }} | 
            @endif
            @if(site_setting('phone'))
                Telefone: {{ site_setting('phone') }} | 
            @endif
            Website: {{ url('/') }}
        </div>
        <div style="margin-top: 10px; font-size: 10px; color: #999;">
            Este documento foi gerado automaticamente em {{ now()->format('d/m/Y \à\s H:i') }}
        </div>
    </div>
</body>
</html> 