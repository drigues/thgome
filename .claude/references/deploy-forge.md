# Deploy — Forge + Hetzner

## Configuração Inicial no Forge

### 1. Site
- **Domain:** portfolio.exemplo.pt
- **PHP Version:** 8.2
- **Project Type:** Laravel
- **Web Directory:** /public

### 2. MySQL — database e user isolados
```sql
CREATE DATABASE portfolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'portfolio_user'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD_AQUI';
GRANT ALL PRIVILEGES ON portfolio_db.* TO 'portfolio_user'@'localhost';
FLUSH PRIVILEGES;
```

### 3. .env em produção — OBRIGATÓRIO verificar

```env
APP_NAME="Portfolio"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://portfolio.exemplo.pt     # ← SEMPRE https://

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio_db
DB_USERNAME=portfolio_user
DB_PASSWORD=STRONG_PASSWORD_AQUI

FILESYSTEM_DISK=public                   # ← Obrigatório para uploads públicos
QUEUE_CONNECTION=sync
CACHE_DRIVER=file
SESSION_DRIVER=file

MAIL_MAILER=smtp
MAIL_HOST=smtp.zoho.eu
MAIL_PORT=465
MAIL_USERNAME=noreply@exemplo.pt
MAIL_PASSWORD=
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=noreply@exemplo.pt
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. SSL
Ativar Let's Encrypt no Forge → botão "SSL" no site.

### 5. Deploy Script COMPLETO

```bash
cd /home/forge/portfolio

# ──────────────────────────────────────────────
# STORAGE PERSISTENTE — crítico para zero-downtime
# Cria pasta shared uma só vez; nas deploys seguintes
# apenas recria o symlink para o storage partilhado
# ──────────────────────────────────────────────
if [ ! -d /home/forge/portfolio/shared ]; then
    mkdir -p /home/forge/portfolio/shared/storage/app/public
    mkdir -p /home/forge/portfolio/shared/storage/logs
    mkdir -p /home/forge/portfolio/shared/storage/framework/cache
    mkdir -p /home/forge/portfolio/shared/storage/framework/sessions
    mkdir -p /home/forge/portfolio/shared/storage/framework/views
fi

# Substituir storage do release pelo storage partilhado
rm -rf /home/forge/portfolio/current/storage
ln -sfn /home/forge/portfolio/shared/storage /home/forge/portfolio/current/storage

# Recriar symlink public/storage
rm -f /home/forge/portfolio/current/public/storage
ln -sfn /home/forge/portfolio/shared/storage/app/public /home/forge/portfolio/current/public/storage

# ──────────────────────────────────────────────
# BUILD
# ──────────────────────────────────────────────
cd /home/forge/portfolio/current

composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
npm ci && npm run build

# ──────────────────────────────────────────────
# LARAVEL
# ──────────────────────────────────────────────
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force              # ← --force obrigatório em produção
php artisan queue:restart
```

### 6. PHP ini — via Forge "PHP Configuration"
```ini
upload_max_filesize = 64M
post_max_size = 64M
max_execution_time = 120
memory_limit = 256M
```

### 7. Nginx — client_max_body_size para vídeos
No Forge → "Nginx Configuration", adicionar dentro do bloco `server {}`:
```nginx
client_max_body_size 200M;
```

### 8. Permissões de storage
```bash
chmod -R 775 /home/forge/portfolio/shared/storage
chown -R forge:www-data /home/forge/portfolio/shared/storage
```

---

## Troubleshooting Frequente

### FileUpload infinito no Filament ao editar
**Causa:** APP_URL com `http://` em produção (HTTPS site).  
**Fix:** Alterar `.env` → `APP_URL=https://...` → `php artisan config:cache`

### Imagens não aparecem após deploy
**Causa:** storage symlink apontou para release anterior ou foi recriado incorretamente.  
**Fix:** Verificar `ls -la public/storage` — deve apontar para `shared/storage/app/public`.

### Migration "Table already exists"
```bash
php artisan tinker
>>> DB::table('migrations')->insert(['migration' => '2024_01_01_NOME_DA_MIGRATION', 'batch' => 999]);
```

### Filament login não funciona
**Causa:** User não existe na tabela `users`.  
**Fix:** `php artisan make:filament-user` (em produção: `php artisan tinker` → `User::factory()->create([...])`)

### 500 após deploy
```bash
tail -100 /home/forge/portfolio/current/storage/logs/laravel.log
# ou
php artisan config:clear && php artisan config:cache
```

---

## Checklist Pré-Launch

- [ ] APP_URL com `https://`
- [ ] APP_DEBUG=false
- [ ] SSL ativo (Let's Encrypt)
- [ ] Testar upload de imagem e vídeo no admin
- [ ] Verificar `public/storage` symlink correto
- [ ] `php artisan storage:link` executado
- [ ] Testar formulário de contacto (receber email)
- [ ] Verificar robots.txt (`/robots.txt`)
- [ ] Verificar sitemap (`/sitemap.xml`)
- [ ] Lighthouse score > 80
- [ ] Google Analytics ID configurado nas settings
- [ ] Backup configurado (spatie/laravel-backup ou Hetzner snapshots)
