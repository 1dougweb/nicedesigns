# Sistema de Faturas com PagarMe - Nice Designs

Este documento descreve como configurar e usar o sistema completo de faturas integrado com PagarMe para geração automática de boletos e PIX.

## 📋 Funcionalidades

### ✅ Implementadas

- **Integração completa com PagarMe API**
- **Geração automática de boletos e PIX**
- **Sistema de cobrança automática por data**
- **Webhooks para atualização de status**
- **Emails automáticos com informações de pagamento**
- **Interface administrativa completa**
- **Comandos Artisan para automação**
- **Sistema de logs e monitoramento**

### 🔧 Componentes Criados

1. **PagarMeService** - Serviço principal de integração
2. **ProcessInvoicePayment** - Job para processamento assíncrono
3. **InvoicePaymentGenerated** - Mailable para notificações
4. **PagarMeWebhookController** - Recebimento de webhooks
5. **Comandos Artisan** - Automação e testes
6. **Migrations** - Campos necessários no banco
7. **Templates de email** - Interface responsiva

## 🚀 Configuração Inicial

### 1. Variáveis de Ambiente

Adicione as seguintes variáveis ao seu arquivo `.env`:

```env
# PagarMe Configuration
PAGARME_API_KEY=ak_test_sua_api_key_aqui
PAGARME_ENCRYPTION_KEY=ek_test_sua_encryption_key_aqui
PAGARME_WEBHOOK_SECRET=seu_webhook_secret_aqui
PAGARME_ENVIRONMENT=sandbox
```

### 2. Configuração no Painel PagarMe

1. **Acesse o painel do PagarMe**
2. **Configure o webhook** para: `https://seudominio.com/pagarme/webhook`
3. **Copie as chaves** API Key e Encryption Key
4. **Configure um secret** para validação de webhooks

### 3. Executar Migrations

```bash
php artisan migrate
```

### 4. Executar Seeders (Configurações)

```bash
php artisan db:seed --class=DatabaseSeeder
```

## 🎯 Como Usar

### 1. Geração Manual de Cobrança

**Via Interface Administrativa:**
1. Acesse Admin → Faturas
2. Clique na fatura desejada
3. Use o botão "Gerar Cobrança PagarMe"
4. Selecione os métodos (Boleto, PIX)
5. Confirme a geração

**Via Comando:**
```bash
# Processar faturas específicas
php artisan invoices:process-auto --limit=10

# Forçar processamento
php artisan invoices:process-auto --force

# Métodos específicos
php artisan invoices:process-auto --methods=boleto,pix
```

### 2. Cobrança Automática

**Habilitar para uma fatura:**
1. Edite a fatura
2. Marque "Cobrança Automática"
3. Defina a data de geração
4. Salve

**Processar automaticamente:**
```bash
# Executar via cron (recomendado diário)
php artisan invoices:process-auto
```

### 3. Monitoramento

**Verificar status:**
```bash
# Testar conexão
php artisan pagarme:test

# Ver configurações
php artisan pagarme:test --show-config

# Criar cobrança de teste
php artisan pagarme:test --create-test-charge
```

## 📧 Sistema de Emails

### Template Responsivo

O sistema inclui um template de email moderno e responsivo que exibe:

- **Informações da fatura**
- **QR Code PIX** (quando disponível)
- **Link para boleto** (quando disponível)
- **Instruções de pagamento**
- **Informações de contato**
- **Avisos de vencimento**

### Personalização

Edite o template em: `resources/views/emails/invoice-payment-generated.blade.php`

## 🔄 Webhooks

### Endpoint

```
POST /pagarme/webhook
```

### Eventos Processados

- **Pagamento confirmado** → Marca fatura como paga
- **Pagamento cancelado** → Atualiza status
- **Falha no pagamento** → Registra erro

### Teste de Webhook

```bash
# Endpoint de teste
POST /pagarme/webhook/test
```

## 🛠️ Comandos Disponíveis

### Processamento de Faturas

```bash
# Processar faturas automáticas
php artisan invoices:process-auto

# Com opções
php artisan invoices:process-auto --limit=50 --methods=boleto,pix --send-email=1
```

### Testes PagarMe

```bash
# Testar conexão
php artisan pagarme:test

# Mostrar configurações
php artisan pagarme:test --show-config

# Criar cobrança de teste
php artisan pagarme:test --create-test-charge --invoice-id=123
```

## 📊 Interface Administrativa

### Funcionalidades Adicionadas

1. **Botão "Gerar Cobrança PagarMe"** na visualização da fatura
2. **Status PagarMe** com cores indicativas
3. **Links diretos** para boleto e PIX
4. **Controles de cobrança automática**
5. **Botões de ação** (consultar status, cancelar)

### Campos Adicionados

- Status PagarMe
- URLs de pagamento
- Códigos PIX
- Data de cobrança automática
- Dados da transação

## 🔐 Segurança

### Validação de Webhooks

- **Verificação de IP** (IPs oficiais do PagarMe)
- **Validação de assinatura** (HMAC SHA-256)
- **Logs detalhados** de todas as requisições

### Dados Sensíveis

- **API Keys** armazenadas em configurações
- **Dados de transação** criptografados no banco
- **Logs** não expõem informações sensíveis

## 📈 Monitoramento e Logs

### Logs Importantes

```bash
# Ver logs do Laravel
tail -f storage/logs/laravel.log | grep -i pagarme

# Logs específicos
tail -f storage/logs/laravel.log | grep -i "webhook\|invoice\|payment"
```

### Métricas

- **Taxa de sucesso** na geração de cobranças
- **Tempo de processamento** dos jobs
- **Status de webhooks** recebidos

## 🚨 Troubleshooting

### Problemas Comuns

1. **Erro de API Key**
   ```
   Solução: Verificar se as chaves estão corretas no .env
   ```

2. **Webhook não recebido**
   ```
   Solução: Verificar URL no painel PagarMe e firewall
   ```

3. **Job não processado**
   ```
   Solução: Verificar se o queue worker está rodando
   ```

### Comandos de Diagnóstico

```bash
# Testar conexão
php artisan pagarme:test

# Verificar configurações
php artisan pagarme:test --show-config

# Limpar cache
php artisan config:clear
php artisan cache:clear
```

## 🔄 Automação com Cron

### Configuração Recomendada

```bash
# Adicionar ao crontab
# Processar faturas automáticas diariamente às 9h
0 9 * * * cd /path/to/project && php artisan invoices:process-auto

# Verificar status de cobranças a cada 4 horas
0 */4 * * * cd /path/to/project && php artisan invoices:sync-status
```

## 📝 Próximos Passos

### Melhorias Futuras

1. **Dashboard de métricas** PagarMe
2. **Relatórios de cobrança** detalhados
3. **Integração com cartão de crédito**
4. **Sistema de assinaturas** recorrentes
5. **API para integração externa**

## 🆘 Suporte

### Documentação Oficial

- [PagarMe API Docs](https://docs.pagar.me/)
- [Laravel Queue](https://laravel.com/docs/queues)
- [Laravel Mail](https://laravel.com/docs/mail)

### Contato

Para dúvidas sobre implementação, consulte a documentação do projeto ou entre em contato com a equipe de desenvolvimento.

---

**Desenvolvido para Nice Designs** 🎨
Sistema completo de faturas com integração PagarMe para automação de cobranças. 