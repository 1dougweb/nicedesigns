<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de Email - {{ $app_name }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        
        .container {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        
        .title {
            color: #1f2937;
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }
        
        .subtitle {
            color: #6b7280;
            font-size: 16px;
            margin: 0;
        }
        
        .content {
            margin: 30px 0;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 40px;
        }
        
        .message {
            color: #374151;
            font-size: 16px;
            text-align: center;
            margin-bottom: 25px;
        }
        
        .info-box {
            background-color: #f3f4f6;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #3b82f6;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #374151;
        }
        
        .info-value {
            color: #6b7280;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
        }
        
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .container {
                padding: 20px;
            }
            
            .title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">ND</div>
            <h1 class="title">{{ $app_name }}</h1>
            <p class="subtitle">Sistema de Email Funcionando</p>
        </div>
        
        <div class="content">
            <div class="success-icon">✓</div>
            
            <p class="message">
                <strong>Parabéns!</strong> Seu sistema de email SMTP está configurado e funcionando corretamente.
                Este é um email de teste enviado em <strong>{{ $datetime }}</strong>.
            </p>
            
            <div class="info-box">
                <div class="info-item">
                    <span class="info-label">Data/Hora:</span>
                    <span class="info-value">{{ $datetime }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Sistema:</span>
                    <span class="info-value">{{ $app_name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value">✅ Funcionando</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tipo:</span>
                    <span class="info-value">Email de Teste</span>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>
                Este email foi enviado automaticamente pelo sistema.<br>
                <strong>{{ $app_name }}</strong> - Agência de Web Design
            </p>
        </div>
    </div>
</body>
</html> 