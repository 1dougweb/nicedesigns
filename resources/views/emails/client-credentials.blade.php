<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suas credenciais de acesso</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        
        .container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        
        .content {
            padding: 30px;
        }
        
        .welcome-message {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2d3748;
        }
        
        .credentials-box {
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .credentials-title {
            font-size: 16px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .credential-item {
            margin-bottom: 15px;
        }
        
        .credential-label {
            display: block;
            font-size: 14px;
            color: #718096;
            margin-bottom: 5px;
        }
        
        .credential-value {
            display: block;
            font-size: 16px;
            font-weight: 600;
            color: #2d3748;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            background: #fff;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
        }
        
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 8px;
            margin: 0 10px 10px 0;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-secondary {
            background: #e2e8f0;
            color: #4a5568;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .security-notice {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        
        .security-notice h3 {
            color: #856404;
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        
        .security-notice p {
            color: #856404;
            margin: 0;
            font-size: 14px;
        }
        
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 14px;
            color: #718096;
            border-top: 1px solid #e2e8f0;
        }
        
        .icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 8px;
            vertical-align: middle;
        }
        
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .header, .content {
                padding: 20px;
            }
            
            .btn {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Bem-vindo ao {{ $siteName }}!</h1>
        </div>
        
        <div class="content">
            <div class="welcome-message">
                Olá <strong>{{ $client->full_name }}</strong>,
            </div>
            
            <p>Sua conta foi criada com sucesso! Agora você pode acessar nosso painel de cliente e acompanhar todos os seus projetos, faturas e muito mais.</p>
            
            <div style="background: #f0f9ff; border: 1px solid #0ea5e9; border-radius: 8px; padding: 15px; margin: 20px 0;">
                <h3 style="color: #0369a1; margin: 0 0 10px 0; font-size: 16px;">📝 Complete seu perfil</h3>
                <p style="color: #0369a1; margin: 0; font-size: 14px;">
                    Para aproveitar ao máximo nossos serviços, complete seu perfil com informações como CPF/CNPJ, telefone e endereço. 
                    Isso nos ajudará a fornecer um atendimento ainda melhor!
                </p>
            </div>
            
            <div class="credentials-box">
                <div class="credentials-title">
                    🔐 Suas credenciais de acesso:
                </div>
                
                <div class="credential-item">
                    <span class="credential-label">Email:</span>
                    <span class="credential-value">{{ $client->email }}</span>
                </div>
                
                <div class="credential-item">
                    <span class="credential-label">Senha temporária:</span>
                    <span class="credential-value">{{ $password }}</span>
                </div>
            </div>
            
            <div class="button-container">
                <a href="{{ $loginUrl }}" class="btn btn-primary">
                    🚀 Acessar minha conta
                </a>
                <a href="{{ $resetUrl }}" class="btn btn-secondary">
                    🔒 Redefinir senha
                </a>
            </div>
            
            <div class="security-notice">
                <h3>⚠️ Importante - Segurança</h3>
                <p>Por questões de segurança, <strong>recomendamos fortemente</strong> que você redefina sua senha no primeiro acesso. Use o botão "Redefinir senha" acima ou altere sua senha após o login.</p>
            </div>
            
            <h3>🎯 O que você pode fazer no painel:</h3>
            <ul>
                <li><strong>👤 Completar Perfil:</strong> Adicione seus dados pessoais, CPF/CNPJ e informações de contato</li>
                <li><strong>📊 Dashboard:</strong> Visualize um resumo de todos os seus projetos e atividades</li>
                <li><strong>📋 Projetos:</strong> Acompanhe o progresso dos seus projetos em tempo real</li>
                <li><strong>💰 Faturas:</strong> Consulte e pague suas faturas online</li>
                <li><strong>📄 Orçamentos:</strong> Visualize e aprove novos orçamentos</li>
                <li><strong>🎧 Suporte:</strong> Abra tickets de suporte e tire suas dúvidas</li>
                <li><strong>🔔 Notificações:</strong> Receba atualizações importantes em tempo real</li>
            </ul>
            
            <p>Se você tiver alguma dúvida ou precisar de ajuda, nossa equipe está sempre disponível para te auxiliar!</p>
        </div>
        
        <div class="footer">
            <p>
                <strong>{{ $siteName }}</strong><br>
                Este email foi enviado automaticamente. Se você não solicitou esta conta, por favor ignore este email.
            </p>
            <p style="margin-top: 10px; font-size: 12px;">
                📧 {{ site_setting('email') }} | 📞 {{ site_setting('phone') }} | 🌐 {{ url('/') }}
            </p>
        </div>
    </div>
</body>
</html> 