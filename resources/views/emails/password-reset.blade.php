<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir senha</title>
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
            background: linear-gradient(135deg,rgb(26, 55, 182) 0%,rgb(101, 19, 155) 100%);
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
        
        .message {
            font-size: 16px;
            margin-bottom: 20px;
            color: #2d3748;
        }
        
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        
        .btn {
            display: inline-block;
            padding: 15px 40px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: linear-gradient(135deg,rgb(26, 55, 182) 0%,rgb(101, 19, 155) 100%);
            color: white!important;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }
        
        .security-notice {
            background: #e3f2fd;
            border: 1px solid #90caf9;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        
        .security-notice h3 {
            color: #1565c0;
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        
        .security-notice p {
            color: #1565c0;
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
        
        .expiry-notice {
            background: #fff3e0;
            border: 1px solid #ffb74d;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        
        .expiry-notice p {
            color: #f57c00;
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }
        
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .header, .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔒 Redefinir Senha</h1>
        </div>
        
        <div class="content">
            <div class="message">
                Olá <strong>{{ $user->full_name }}</strong>,
            </div>
            
            <p>Você recebeu este email porque foi solicitada uma redefinição de senha para sua conta.</p>
            
            <p>Para criar uma nova senha, clique no botão abaixo:</p>
            
            <div class="button-container">
                <a href="{{ $resetUrl }}" class="btn">
                    🔑 Redefinir Minha Senha
                </a>
            </div>
            
            <div class="expiry-notice">
                <p>⏰ Este link expira em 60 minutos por questões de segurança</p>
            </div>
            
            <div class="security-notice">
                <h3>🛡️ Dicas de Segurança</h3>
                <p>• Use uma senha forte com pelo menos 8 caracteres<br>
                • Combine letras maiúsculas, minúsculas, números e símbolos<br>
                • Não use informações pessoais na senha<br>
                • Não compartilhe sua senha com ninguém</p>
            </div>
            
            <p>Se você não solicitou esta redefinição de senha, nenhuma ação é necessária. Sua senha atual permanece inalterada.</p>
            
            <p>Em caso de dúvidas ou se você não conseguir redefinir sua senha, entre em contato conosco.</p>
        </div>
        
        <div class="footer">
            <p>
                <strong>{{ $siteName }}</strong><br>
                Este email foi enviado automaticamente. Por favor, não responda a este email.
            </p>
            <p style="margin-top: 10px; font-size: 12px;">
                📧 {{ site_setting('email') }} | 📞 {{ site_setting('phone') }} | 🌐 {{ url('/') }}
            </p>
        </div>
    </div>
</body>
</html> 