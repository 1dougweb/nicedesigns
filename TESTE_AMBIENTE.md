# 🧪 Ambiente de Teste - Nice Designs

Este documento explica como configurar e usar o ambiente de teste completo do sistema Nice Designs com integração PagarMe.

## 🚀 Configuração Rápida

### Comando Principal
```bash
# Configurar ambiente completo de teste
php artisan test:setup --fresh --with-pagarme
```

### Opções Disponíveis
```bash
# Setup básico (mantém dados existentes)
php artisan test:setup

# Setup completo (apaga tudo e recria)
php artisan test:setup --fresh

# Apenas popular dados (não migrar)
php artisan test:setup --seed-only

# Incluir configuração PagarMe interativa
php artisan test:setup --with-pagarme
```

## 🔄 Reset Rápido

```bash
# Reset rápido (apenas dados)
php artisan test:reset --quick --confirm

# Reset completo (migrations + dados)
php artisan test:reset --confirm
```

## 📊 Dados Criados

### 👨‍💼 Usuários Administrativos
- **Admin Principal**: `admin@nicedesigns.com.br` / `password`
- **Suporte**: `suporte@nicedesigns.com.br` / `password`

### 👥 Clientes de Teste
- **João Silva**: `joao.silva@email.com` / `password` (Pessoa Física)
- **TechCorp**: `contato@techcorp.com.br` / `password` (Empresa)
- **LojaSA**: `vendas@lojasa.com.br` / `password` (E-commerce)
- **+ 10 clientes aleatórios** com dados brasileiros realistas

### 📋 Projetos
- **30+ projetos** distribuídos entre os clientes
- Diferentes status: planejamento, em andamento, revisão, concluído
- Orçamentos variados de R$ 2.000 a R$ 50.000

### 💰 Faturas
- **60+ faturas** com cenários diversos:
  - ✅ **20 pagas** (com diferentes métodos)
  - ⏳ **15 pendentes** (prontas para teste)
  - 🔴 **5 vencidas** (para teste de cobrança)
  - 🤖 **8 com cobrança automática** habilitada
  - 💳 **10 com dados PagarMe** simulados
  - 💎 **3 de alto valor** (R$ 10k+)

### 📝 Conteúdo
- **18 posts** no blog
- **27 projetos** no portfólio
- **Categorias** configuradas
- **Configurações** completas do sistema

## 🧪 Cenários de Teste

### 1. **Teste de Faturas Pendentes**
```bash
# Listar faturas prontas para cobrança automática
php artisan invoices:process-auto --limit=5

# Ver faturas criadas no admin
# Acesse: /admin/invoices
```

### 2. **Teste de Integração PagarMe**
```bash
# Testar conexão
php artisan pagarme:test --show-config

# Criar cobrança de teste
php artisan pagarme:test --create-test-charge
```

### 3. **Teste de Webhooks**
```bash
# Simular webhook (POST para teste)
curl -X POST http://localhost:8000/pagarme/webhook/test \
  -H "Content-Type: application/json" \
  -d '{"test": "webhook"}'
```

### 4. **Teste de Emails**
```bash
# Configurar Mailtrap ou similar no .env
# Processar fatura com email
php artisan invoices:process-auto --send-email=1
```

### 5. **Teste de Queue**
```bash
# Executar worker em terminal separado
php artisan queue:work

# Em outro terminal, processar faturas
php artisan invoices:process-auto --limit=3
```

## 🔧 Configuração PagarMe

### 1. **Obter Chaves de Teste**
1. Acesse [PagarMe Dashboard](https://dashboard.pagar.me)
2. Crie uma conta ou faça login
3. Vá em **Configurações > Chaves de API**
4. Copie as chaves de **teste/sandbox**

### 2. **Configurar no Sistema**
```bash
# Via comando interativo
php artisan test:setup --with-pagarme

# Ou manualmente no .env
PAGARME_API_KEY=ak_test_sua_chave_aqui
PAGARME_ENCRYPTION_KEY=ek_test_sua_chave_aqui
PAGARME_WEBHOOK_SECRET=seu_webhook_secret
PAGARME_ENVIRONMENT=sandbox
```

### 3. **Configurar Webhook**
- **URL**: `https://seudominio.com/pagarme/webhook`
- **Events**: Todos os eventos de transação
- **Secret**: Use o mesmo configurado no .env

### 4. **Testar Conexão**
```bash
php artisan pagarme:test
```

## 📱 URLs de Teste

### Administrativo
- **Admin Dashboard**: `/admin`
- **Faturas**: `/admin/invoices`
- **Clientes**: `/admin/client-projects`
- **Configurações**: `/admin/settings`

### Cliente
- **Área do Cliente**: `/client`
- **Projetos**: `/client/projects`
- **Faturas**: `/client/invoices`
- **Suporte**: `/client/support`

### APIs
- **Webhook PagarMe**: `/pagarme/webhook`
- **Webhook Teste**: `/pagarme/webhook/test`

## 🛠️ Comandos Úteis

### Gerenciamento de Dados
```bash
# Criar mais dados de teste
php artisan db:seed --class=TestDataSeeder

# Limpar cache
php artisan config:clear && php artisan cache:clear

# Gerar nova fatura de teste
php artisan tinker
>>> Invoice::factory()->pending()->create()
```

### Monitoramento
```bash
# Ver logs em tempo real
tail -f storage/logs/laravel.log

# Logs específicos do PagarMe
tail -f storage/logs/laravel.log | grep -i pagarme

# Status das filas
php artisan queue:monitor
```

### Debug
```bash
# Executar job específico
php artisan queue:work --once

# Falhar jobs para debug
php artisan queue:failed

# Reprocessar jobs falhados
php artisan queue:retry all
```

## 📊 Cenários Específicos

### **Fatura com Cobrança Automática**
1. Acesse uma fatura pendente
2. Clique em "Habilitar Cobrança Automática"
3. Configure data futura
4. Execute: `php artisan invoices:process-auto`

### **Fatura Manual**
1. Acesse `/admin/invoices/{id}`
2. Clique em "Gerar Cobrança PagarMe"
3. Selecione métodos (PIX, Boleto)
4. Confirme geração

### **Teste de Webhook**
1. Configure webhook no PagarMe
2. Gere uma cobrança
3. Simule pagamento no dashboard PagarMe
4. Verifique atualização automática

### **Cliente Testando**
1. Login como cliente de teste
2. Acesse `/client/invoices`
3. Visualize fatura com PIX/Boleto
4. Teste links de pagamento

## 🚨 Troubleshooting

### **Erro: PagarMe API Key inválida**
```bash
# Verificar configuração
php artisan pagarme:test --show-config

# Reconfigurar
php artisan test:setup --with-pagarme
```

### **Jobs não executando**
```bash
# Verificar se worker está rodando
php artisan queue:work

# Verificar tabela de jobs
php artisan queue:table && php artisan migrate
```

### **Webhook não recebido**
```bash
# Testar URL
curl -X POST http://localhost:8000/pagarme/webhook/test

# Verificar logs
tail -f storage/logs/laravel.log | grep webhook
```

### **Faturas não sendo criadas**
```bash
# Verificar dados necessários
php artisan tinker
>>> User::where('role', 'client')->count()

# Recriar dados
php artisan test:reset --quick --confirm
```

## 💡 Dicas Importantes

1. **Sempre use chaves de teste** em ambiente de desenvolvimento
2. **Execute queue:work** em terminal separado para processar jobs
3. **Configure Mailtrap** para testar emails
4. **Use --confirm** nos comandos para automação
5. **Monitore logs** durante testes para debug

## 🎯 Fluxo Completo de Teste

```bash
# 1. Configurar ambiente
php artisan test:setup --fresh --with-pagarme

# 2. Iniciar worker (novo terminal)
php artisan queue:work

# 3. Testar PagarMe
php artisan pagarme:test

# 4. Processar faturas automáticas
php artisan invoices:process-auto --limit=3

# 5. Acessar admin e verificar resultados
# URL: /admin/invoices

# 6. Testar como cliente
# Login: joao.silva@email.com / password
# URL: /client/invoices
```

---

**🎨 Desenvolvido para Nice Designs**  
Sistema completo de teste para desenvolvimento e demonstração. 