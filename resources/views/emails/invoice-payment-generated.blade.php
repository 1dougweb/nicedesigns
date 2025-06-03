<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatura {{ $invoice->invoice_number }} - Formas de Pagamento</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .invoice-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .invoice-info h3 {
            margin: 0 0 15px 0;
            color: #667eea;
            font-size: 18px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            padding: 5px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 16px;
            color: #28a745;
        }
        .payment-methods {
            margin: 30px 0;
        }
        .payment-method {
            background-color: #fff;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin: 15px 0;
            transition: border-color 0.3s;
        }
        .payment-method:hover {
            border-color: #667eea;
        }
        .payment-method h4 {
            margin: 0 0 10px 0;
            color: #495057;
            display: flex;
            align-items: center;
        }
        .payment-icon {
            width: 24px;
            height: 24px;
            margin-right: 10px;
            background-color: #667eea;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        .payment-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            margin: 10px 0;
            font-weight: bold;
            text-align: center;
            transition: transform 0.3s;
        }
        .payment-btn:hover {
            transform: translateY(-2px);
            text-decoration: none;
            color: white;
        }
        .pix-code {
            background-color: #f8f9fa;
            border: 1px dashed #dee2e6;
            border-radius: 4px;
            padding: 10px;
            font-family: monospace;
            font-size: 12px;
            word-break: break-all;
            margin: 10px 0;
        }
        .qr-code {
            text-align: center;
            margin: 15px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 5px 0;
            color: #6c757d;
            font-size: 14px;
        }
        .contact-info {
            margin: 20px 0;
            text-align: center;
        }
        .contact-info a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
        }
        .urgent-notice {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
        .urgent-notice strong {
            color: #721c24;
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
            }
            .header, .content {
                padding: 20px;
            }
            .info-row {
                flex-direction: column;
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>💳 Formas de Pagamento Disponíveis</h1>
            <p>Sua fatura está pronta para pagamento</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Olá, <strong>{{ $client->full_name }}</strong>!</p>
            
            <p>Sua fatura já está disponível e você pode pagá-la utilizando as opções abaixo. Escolha a forma de pagamento que preferir:</p>

            <!-- Invoice Info -->
            <div class="invoice-info">
                <h3>📋 Informações da Fatura</h3>
                <div class="info-row">
                    <span>Número:</span>
                    <span><strong>{{ $invoice->invoice_number }}</strong></span>
                </div>
                <div class="info-row">
                    <span>Descrição:</span>
                    <span>{{ $invoice->title }}</span>
                </div>
                <div class="info-row">
                    <span>Data de Vencimento:</span>
                    <span>{{ $invoice->due_date->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span>Valor Total:</span>
                    <span>{{ $invoice->formatted_total_amount }}</span>
                </div>
            </div>

            <!-- Urgent Notice -->
            @if($invoice->days_until_due !== null && $invoice->days_until_due <= 3)
            <div class="urgent-notice">
                <strong>⚠️ Atenção:</strong> 
                @if($invoice->days_until_due <= 0)
                    Esta fatura está <strong>vencida</strong>. Realize o pagamento o quanto antes para evitar juros.
                @else
                    Esta fatura vence em <strong>{{ $invoice->days_until_due }} dia(s)</strong>. Não esqueça de realizar o pagamento.
                @endif
            </div>
            @endif

            <!-- Payment Methods -->
            <div class="payment-methods">
                <h3>💰 Escolha sua Forma de Pagamento</h3>

                @if($invoice->hasPix())
                <!-- PIX -->
                <div class="payment-method">
                    <h4>
                        <span class="payment-icon">📱</span>
                        PIX - Pagamento Instantâneo
                    </h4>
                    <p>Pagamento aprovado em tempo real, disponível 24h por dia.</p>
                    
                    @if($invoice->pix_qr_code)
                    <div class="qr-code">
                        <p><strong>Escaneie o QR Code:</strong></p>
                        <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(200)->generate($invoice->pix_code)) }}" 
                             alt="QR Code PIX" style="max-width: 200px;">
                    </div>
                    @endif

                    @if($invoice->pix_code)
                    <p><strong>Ou copie o código PIX:</strong></p>
                    <div class="pix-code">{{ $invoice->pix_code }}</div>
                    @endif

                    <a href="{{ route('client.invoices.show', $invoice) }}" class="payment-btn">
                        📱 Ver Detalhes do PIX
                    </a>
                </div>
                @endif

                @if($invoice->hasBoleto())
                <!-- Boleto -->
                <div class="payment-method">
                    <h4>
                        <span class="payment-icon">🏛️</span>
                        Boleto Bancário
                    </h4>
                    <p>Pode ser pago em qualquer banco, casa lotérica ou internet banking.</p>
                    <p><strong>Vencimento:</strong> {{ $invoice->due_date->format('d/m/Y') }}</p>
                    
                    <a href="{{ $invoice->boleto_url }}" target="_blank" class="payment-btn">
                        🏛️ Baixar Boleto
                    </a>
                </div>
                @endif

                @if($invoice->payment_url)
                <!-- Link de Pagamento Geral -->
                <div class="payment-method">
                    <h4>
                        <span class="payment-icon">🌐</span>
                        Portal de Pagamento
                    </h4>
                    <p>Acesse nosso portal seguro com todas as opções de pagamento disponíveis.</p>
                    
                    <a href="{{ $invoice->payment_url }}" target="_blank" class="payment-btn">
                        🌐 Acessar Portal de Pagamento
                    </a>
                </div>
                @endif
            </div>

            <!-- Payment Instructions -->
            @if($invoice->payment_instructions)
            <div class="invoice-info">
                <h3>📝 Instruções de Pagamento</h3>
                <p>{{ $invoice->payment_instructions }}</p>
            </div>
            @endif

            <!-- Contact Info -->
            <div class="contact-info">
                <p><strong>Precisa de ajuda?</strong></p>
                <p>
                    @if($contactEmail)
                        <a href="mailto:{{ $contactEmail }}">📧 {{ $contactEmail }}</a>
                    @endif
                    @if($contactPhone)
                        <a href="tel:{{ $contactPhone }}">📞 {{ $contactPhone }}</a>
                    @endif
                    @if($contactWhatsapp)
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $contactWhatsapp) }}" target="_blank">
                            💬 WhatsApp
                        </a>
                    @endif
                </p>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('client.dashboard') }}" class="payment-btn">
                    🏠 Acessar Área do Cliente
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>{{ $siteName }}</strong></p>
            <p>Este email foi enviado automaticamente pelo nosso sistema de faturas.</p>
            <p style="font-size: 12px; color: #999;">
                © {{ date('Y') }} {{ $siteName }}. Todos os direitos reservados.
            </p>
        </div>
    </div>
</body>
</html> 