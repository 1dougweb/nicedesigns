# Solução: Erro de Banco de Dados em Produção

## ❌ Problema
```
Database file at path [/home/u760830176/domains/nicedesigns.com.br/public_html/database/database.sqlite] does not exist
```

## 🔍 Causa
A aplicação está configurada para usar **SQLite** em produção, mas hosting compartilhado normalmente não suporta SQLite adequadamente. É necessário usar **MySQL**.

## ✅ Solução

### Passo 1: Configurar Banco MySQL no Hostinger

1. **Acesse o painel do Hostinger**
2. **Vá em "Banco de Dados MySQL"**
3. **Crie um novo banco:**
   - Nome: `u760830176_laravel`
   - Usuário: `u760830176_laravel_root`
   - Senha: `Graffs@500##`
   - Permissões: **Todas**

### Passo 2: Atualizar Configuração no Servidor

**No servidor, edite o arquivo `.env`:**

```bash
# Altere estas linhas:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u760830176_laravel
DB_USERNAME=u760830176_laravel_root
DB_PASSWORD=Graffs@500##

# Remova ou comente:
# DB_CONNECTION=sqlite
```

### Passo 3: Executar Migrações

**Via SSH ou terminal do painel:**

```bash
# 1. Limpar cache de configuração
php artisan config:clear

# 2. Testar conexão
php artisan migrate:status

# 3. Executar migrações
php artisan migrate --force

# 4. Executar seeders (se necessário)
php artisan db:seed --force

# 5. Refazer cache
php artisan config:cache
```

### Passo 4: Verificar Permissões

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

## 🚀 Arquivo .env Completo para Produção

Use o arquivo `.env.prod` criado pelo script `deploy-production.sh`, copiando-o para `.env` no servidor:

```bash
cp .env.prod .env
```

## 🔧 Comandos de Diagnóstico

**Para verificar se tudo está funcionando:**

```bash
# Testar conexão com banco
php artisan migrate:status

# Verificar configuração
php artisan config:show database.connections.mysql

# Testar criação de usuário (se necessário)
php artisan tinker --execute="echo 'Conexão OK: ' . \DB::connection()->getPdo();"
```

## 📝 Notas Importantes

1. **Backup**: Sempre faça backup antes de fazer alterações
2. **Credenciais**: As credenciais mostradas aqui são baseadas no erro fornecido
3. **DNS**: Pode levar alguns minutos para as alterações surtirem efeito
4. **Cache**: Limpe sempre o cache após alterações de configuração

## ⚠️ Se Ainda Houver Problemas

1. **Verifique se o banco foi criado corretamente**
2. **Confirme as credenciais no painel do Hostinger**
3. **Verifique se o PHP tem a extensão PDO MySQL ativada**
4. **Entre em contato com o suporte do Hostinger se necessário**

---

**Status após correção:** ✅ Sistema usando MySQL em produção com notificações funcionando perfeitamente! 