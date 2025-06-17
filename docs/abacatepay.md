# Configuração do AbacatePay

Este documento descreve como configurar o AbacatePay no sistema.

## Variáveis de Ambiente

Adicione as seguintes variáveis ao seu arquivo `.env`:

```env
# AbacatePay
ABACATEPAY_TOKEN=seu_token_aqui
ABACATEPAY_ENVIRONMENT=sandbox # ou production
ABACATEPAY_WEBHOOK_SECRET=seu_webhook_secret_aqui
```

## Obtendo as Credenciais

1. Acesse o [Dashboard do AbacatePay](https://dashboard.abacatepay.com)
2. Vá para "Configurações" > "API Keys"
3. Gere uma nova API Key ou copie uma existente
4. Copie o token gerado e adicione ao `ABACATEPAY_TOKEN`

## Configurando o Webhook

1. No dashboard do AbacatePay, vá para "Configurações" > "Webhooks"
2. Adicione uma nova URL de webhook: `https://seu-dominio.com/webhooks/abacatepay`
3. Copie o Webhook Secret gerado e adicione ao `ABACATEPAY_WEBHOOK_SECRET`

## Ambientes

O sistema suporta dois ambientes:

- **Sandbox**: Ambiente de testes
  - URL: https://sandbox.abacatepay.com/v1
  - Use para desenvolvimento e testes

- **Production**: Ambiente de produção
  - URL: https://api.abacatepay.com/v1
  - Use para ambiente de produção

## Configurações Padrão

As configurações padrão do sistema incluem:

- Prazo de vencimento: 7 dias
- Métodos de pagamento suportados:
  - PIX
  - Boleto
  - Cartão de Crédito
  - Cartão de Débito

## Testando a Conexão

Após configurar as credenciais, você pode testar a conexão:

1. Acesse o painel administrativo
2. Vá para "Configurações" > "AbacatePay"
3. Clique em "Testar Conexão"

Se tudo estiver configurado corretamente, você verá uma mensagem de sucesso.

## Solução de Problemas

Se encontrar problemas:

1. Verifique se todas as variáveis de ambiente estão configuradas
2. Confirme se o token está correto
3. Verifique se o webhook está configurado corretamente
4. Certifique-se de que o ambiente (sandbox/production) está correto

## Suporte

Para suporte adicional:

- Email: suporte@abacatepay.com
- Documentação: https://docs.abacatepay.com
- Status: https://status.abacatepay.com 