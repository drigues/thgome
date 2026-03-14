---
name: portfolio
description: "Use this skill to create a complete portfolio website with full admin panel from scratch. Triggers include: any mention of 'portfolio', 'portfólio', 'site de portfólio', 'portfolio admin', 'portfolio com projetos', 'portfolio com fotos e vídeos', or requests to build a personal/agency portfolio with project management, photo galleries, video embeds, services, blog, and contact. The system uses Laravel 11 + Filament 3 + Spatie Media Library + Tailwind CSS + Alpine.js + GSAP + Lenis. Always read this skill FIRST before generating any portfolio project code — it includes critical production gotchas that prevent common deployment errors."
---

# Portfolio System — 99web

> **Stack:** Laravel 11 · Filament 3 · Spatie MediaLibrary · Tailwind CSS · Alpine.js · GSAP · Lenis · Splitting.js  
> **Deploy:** GitHub → Laravel Forge → Hetzner  
> **Idioma:** Europeu PT (não brasileiro)

---

## ⚠️ GOTCHAS CRÍTICOS — Ler Antes de Gerar Qualquer Código

Estas são as lições aprendidas em produção que **devem** estar presentes desde o início:

### 1. APP_URL deve ser `https://` em produção
```env
# ✅ CORRETO
APP_URL=https://portfolio.example.com

# ❌ ERRADO — causa FileUpload infinito no Filament ao editar registos
APP_URL=http://portfolio.example.com
```

### 2. Filament autentica na tabela `users`
Nunca criar tabela `admins` separada. Usar `users` com `is_admin` bool ou guard padrão.
```bash
php artisan make:filament-user
# Cria user na tabela `users` — é o único lugar onde o Filament autentica
```

### 3. `php artisan migrate` em produção requer `--force`
```bash
# Em produção (via Forge ou deploy script)
php artisan migrate --force
```

### 4. Zero-downtime deployments quebram storage symlinks
O Forge com zero-downtime cria releases em pastas novas. O `storage:link` aponta para `releases/X/storage` que muda a cada deploy.

**Solução: pasta `shared/` persistente no Forge deploy script:**
```bash
# No deploy script do Forge — OBRIGATÓRIO para storage persistente
if [ ! -d /home/forge/portfolio/shared/storage ]; then
    cp -r /home/forge/portfolio/current/storage /home/forge/portfolio/shared/storage
fi
ln -sfn /home/forge/portfolio/shared/storage /home/forge/portfolio/current/storage
cd /home/forge/portfolio/current && php artisan storage:link
```

### 5. Conflicts de migrations (tabela já existe)
Se migration falhar com "table already exists", resolver via tinker:
```bash
php artisan tinker
DB::table('migrations')->insert(['migration' => '2024_01_01_create_X_table', 'batch' => 999]);
```

### 6. WebP no Intervention Image — usar com cautela
Conversão automática para WebP pode causar perda visível de qualidade em fotografias. Usar apenas se Lighthouse Score for prioridade e cliente aceitar.

### 7. Spatie MediaLibrary — Disk público no .env
```env
FILESYSTEM_DISK=public
```
Sem isto, os uploads ficam inacessíveis publicamente.

---

## 1. Project Scaffold

```bash
# Criar projeto
laravel new portfolio && cd portfolio

# PHP packages
composer require \
  filament/filament:"^3.0" \
  spatie/laravel-medialibrary \
  spatie/laravel-sluggable \
  spatie/laravel-sitemap \
  intervention/image-laravel

# Filament install (cria panel /admin)
php artisan filament:install --panels

# NPM
npm install alpinejs gsap @studio-freight/lenis splitting

# Criar utilizador admin
php artisan make:filament-user
```

### .env (desenvolvimento)
```env
APP_NAME="Portfolio"
APP_ENV=local
APP_KEY=  # gerado por artisan key:generate
APP_DEBUG=true
APP_URL=http://portfolio.test

DB_DATABASE=portfolio
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync
CACHE_DRIVER=file
SESSION_DRIVER=file
MAIL_MAILER=log
```

### .env (produção — template)
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://DOMINIO_AQUI.pt   # ← SEMPRE https://

FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync
CACHE_DRIVER=file
```

### vite.config.js
```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

### resources/js/app.js
```js
import Alpine from 'alpinejs';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from '@studio-freight/lenis';
import Splitting from 'splitting';

gsap.registerPlugin(ScrollTrigger);
window.Alpine = Alpine;
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
window.Splitting = Splitting;

// Lenis smooth scroll
const lenis = new Lenis({ duration: 1.2, easing: t => Math.min(1, 1.001 - Math.pow(2, -10 * t)) });
lenis.on('scroll', ScrollTrigger.update);
gsap.ticker.add((time) => lenis.raf(time * 1000));
gsap.ticker.lagSmoothing(0);

Alpine.start();
```

### resources/css/app.css
```css
@tailwind base;
@tailwind components;
@tailwind utilities;

@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap');

@layer base {
    :root {
        --color-bg: #0A0A0A;
        --color-bg-alt: #111111;
        --color-bg-card: #161616;
        --color-text: #F0F0F0;
        --color-text-muted: #888888;
        --color-accent: #E8FF47;      /* amarelo neón — personalizável por projeto */
        --color-accent-dark: #c8df2a;
        --color-border: #222222;
        --font-heading: 'Syne', sans-serif;
        --font-body: 'Inter', sans-serif;
    }
    html { @apply bg-[var(--color-bg)] text-[var(--color-text)] antialiased; }
    body { font-family: var(--font-body); }
    h1, h2, h3, h4, h5 { font-family: var(--font-heading); }
}
```

> **Nota de design:** A cor accent `--color-accent: #E8FF47` é o default. Ajustar ao branding do cliente. O tema escuro com accent neon é o padrão de portfolio contemporâneo.

### tailwind.config.js
```js
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                bg: { DEFAULT: '#0A0A0A', alt: '#111111', card: '#161616' },
                accent: { DEFAULT: '#E8FF47', dark: '#c8df2a' },
                border: '#222222',
            },
            fontFamily: {
                heading: ['Syne', 'sans-serif'],
                body: ['Inter', 'sans-serif'],
            },
        },
    },
    plugins: [],
};
```

---

## 2. Database Schema

Todas as tabelas têm `timestamps`. Usar `softDeletes` onde indicado.

### settings
Loja key-value para configurações globais do site.
```
id, key (string unique), value (text null)
```
Model `Setting` com:
```php
public static function get(string $key, $default = null): mixed
public static function set(string $key, mixed $value): void
```

**Seed keys obrigatórias:** site_name, site_tagline, site_description, contact_email, contact_phone, address, social_instagram, social_linkedin, social_github, social_behance, social_dribbble, google_analytics_id, seo_title_suffix, hero_title, hero_subtitle, hero_cta_text, about_title, about_text, about_cv_url

### categories
Categorias para projetos.
```
id, name (string), slug (unique, auto via sluggable), color (string null — hex), sort_order (int 0), is_active (bool true)
```
Seed: Web Design, Desenvolvimento, Branding, Motion, Fotografia

### projects
Projecto principal — suporta fotos e vídeos via MediaLibrary.
```
id, title, slug (unique, auto), excerpt (string 255), description (longtext null),
client (string null), url (string null),
year (year null),
category_id (FK, null), 
is_featured (bool false), is_active (bool true),
sort_order (int 0),
meta_title (string null), meta_description (string null),
softDeletes, timestamps
```

**Relações MediaLibrary:**
```php
// Coleções registadas no Model:
$this->addMediaCollection('cover')->singleFile();
$this->addMediaCollection('gallery');    // múltiplas fotos
$this->addMediaCollection('videos');    // ficheiros de vídeo (mp4 etc.)
```

**Video embeds** (YouTube / Vimeo) são guardados como JSON na tabela:
```
video_embeds (json null) — array de [{platform: 'youtube'|'vimeo', embed_id: 'xxx', title: 'xxx'}]
```

### services
Serviços/competências exibidos no site.
```
id, title, description (text), icon (string null — nome Heroicon ou SVG inline), sort_order (int 0), is_active (bool true)
```

### testimonials
Depoimentos de clientes.
```
id, name, company (null), role (null), content (text), avatar (null — path), rating (tinyint 1-5 default 5), is_active (bool true), sort_order (int 0)
```
Avatar: uploaded via Filament FileUpload, guardado no disk public.

### posts
Blog/artigos — opcional mas incluído no scaffold.
```
id, title, slug (unique, auto), excerpt (string), content (longtext — HTML via TinyMCE/Quill), cover (null),
is_published (bool false), published_at (timestamp null),
meta_title (null), meta_description (null),
softDeletes, timestamps
```

### contact_messages
Mensagens recebidas pelo formulário de contacto.
```
id, name, email, subject (null), message (text), is_read (bool false), timestamps
```

---

## 3. Models

### Setting
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
```

### Project (Model completo com MediaLibrary)
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Project extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasSlug;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'description', 'client', 'url',
        'year', 'category_id', 'is_featured', 'is_active',
        'sort_order', 'meta_title', 'meta_description', 'video_embeds',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'video_embeds' => 'array',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('videos');
    }

    // Helper: URL da capa
    public function getCoverUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('cover') ?: asset('images/placeholder.jpg');
    }

    // Scope activos e ordenados
    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeFeatured($q) { return $q->where('is_featured', true); }
    public function scopeOrdered($q) { return $q->orderBy('sort_order')->orderByDesc('year'); }
}
```

---

## 4. Filament Admin Panel

**Prefixo do painel:** `/admin`  
**Guard:** `web` (tabela `users`)

### ProjectResource — o mais complexo
```php
// Tabs no form: Geral | Média | SEO
// Sections importantes:
```

**Schema do form (order matters):**

**Tab Geral:**
- `TextInput::make('title')` required → `afterStateUpdated` regenera slug
- `TextInput::make('slug')` — disabled, auto-gerado
- `Select::make('category_id')` → `Category::active()` options
- `Textarea::make('excerpt')` maxLength 255
- `RichEditor::make('description')` — nullable
- `TextInput::make('client')`, `TextInput::make('url')` (url validation), `TextInput::make('year')`
- `Toggle::make('is_featured')`, `Toggle::make('is_active')` default true
- `TextInput::make('sort_order')` numeric default 0

**Tab Média — CRÍTICO:**
```php
// Cover — SpatieMediaLibraryFileUpload
SpatieMediaLibraryFileUpload::make('cover')
    ->collection('cover')
    ->image()
    ->imageResizeMode('cover')
    ->imageResizeTargetWidth(1200)
    ->imageResizeTargetHeight(800)
    ->disk('public')
    ->visibility('public'),

// Gallery — múltiplos
SpatieMediaLibraryFileUpload::make('gallery')
    ->collection('gallery')
    ->image()
    ->multiple()
    ->reorderable()
    ->disk('public')
    ->visibility('public'),

// Vídeos — ficheiros mp4/webm
SpatieMediaLibraryFileUpload::make('videos')
    ->collection('videos')
    ->acceptedFileTypes(['video/mp4', 'video/webm'])
    ->multiple()
    ->disk('public')
    ->visibility('public'),

// Video Embeds (YouTube/Vimeo) — Repeater
Repeater::make('video_embeds')
    ->schema([
        Select::make('platform')
            ->options(['youtube' => 'YouTube', 'vimeo' => 'Vimeo'])
            ->required(),
        TextInput::make('embed_id')
            ->label('ID do Vídeo')
            ->helperText('Para YouTube: o código após ?v= | Para Vimeo: o número do URL')
            ->required(),
        TextInput::make('title')->label('Título (opcional)'),
    ])
    ->addActionLabel('Adicionar vídeo embed')
    ->columns(3),
```

**Tab SEO:**
- `TextInput::make('meta_title')`
- `Textarea::make('meta_description')`

**Table columns:**
```php
SpatieMediaLibraryImageColumn::make('cover')->collection('cover')->circular(false),
TextColumn::make('title')->searchable()->sortable(),
TextColumn::make('category.name')->badge(),
IconColumn::make('is_featured')->boolean(),
IconColumn::make('is_active')->boolean(),
TextColumn::make('year')->sortable(),
TextColumn::make('sort_order')->sortable(),
```

**Table filters:**
```php
SelectFilter::make('category_id')->relationship('category', 'name'),
TernaryFilter::make('is_featured'),
TernaryFilter::make('is_active'),
```

**Table actions:** Edit, Delete (soft), Restore, ForceDelete

### SettingResource — Página Customizada
Usar `Filament\Resources\Pages\Page` em vez de CRUD normal. Uma página `/admin/settings` com form de todas as settings agrupadas em tabs:

- **Tab Geral:** site_name, site_tagline, site_description, contact_email, contact_phone, address
- **Tab Redes Sociais:** social_instagram, social_linkedin, social_github, social_behance, social_dribbble
- **Tab Homepage:** hero_title, hero_subtitle, hero_cta_text
- **Tab Sobre:** about_title, about_text (RichEditor), about_cv_url (FileUpload)
- **Tab SEO:** seo_title_suffix, google_analytics_id

Guardar: `foreach ($data as $key => $value) { Setting::set($key, $value); }`

### Outros Resources
- **CategoryResource:** simples, name + color (ColorPicker) + sort_order + is_active
- **ServiceResource:** title + description + icon + sort_order + is_active
- **TestimonialResource:** todos os campos + FileUpload para avatar (disk public)
- **PostResource:** title + slug + excerpt + RichEditor content + FileUpload cover + is_published + published_at
- **ContactMessageResource:** read-only, sem form de edição, apenas view + toggle is_read + delete

### Filament Navigation
Agrupar no painel por grupos:
```
Portfolio → Projetos, Categorias
Conteúdo → Serviços, Testemunhos, Posts
Contacto → Mensagens (badge com não lidas)
Config → Definições
```

Badge de mensagens não lidas:
```php
->navigationBadge(fn () => ContactMessage::where('is_read', false)->count())
->navigationBadgeColor('warning')
```

---

## 5. Migrations — Ordem e Detalhes

Criar nesta ordem (respeitando FK):

```
create_settings_table
create_categories_table
create_projects_table        ← FK: category_id → categories
create_services_table
create_testimonials_table
create_posts_table
create_contact_messages_table
```

**create_projects_table — completo:**
```php
Schema::create('projects', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->string('excerpt', 255)->nullable();
    $table->longText('description')->nullable();
    $table->string('client')->nullable();
    $table->string('url')->nullable();
    $table->year('year')->nullable();
    $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
    $table->json('video_embeds')->nullable();
    $table->boolean('is_featured')->default(false);
    $table->boolean('is_active')->default(true);
    $table->integer('sort_order')->default(0);
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();
    $table->softDeletes();
    $table->timestamps();
});
```

**Spatie MediaLibrary migration** — é gerada automaticamente via:
```bash
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"
php artisan migrate
```

---

## 6. Routes

```php
// web.php
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ContactController;

Route::get('/', [PortfolioController::class, 'home'])->name('home');
Route::get('/projetos', [PortfolioController::class, 'projects'])->name('projects');
Route::get('/projetos/{project:slug}', [PortfolioController::class, 'project'])->name('project');
Route::get('/sobre', [PortfolioController::class, 'about'])->name('about');
Route::get('/servicos', [PortfolioController::class, 'services'])->name('services');
Route::get('/blog', [PortfolioController::class, 'blog'])->name('blog');
Route::get('/blog/{post:slug}', [PortfolioController::class, 'post'])->name('post');
Route::get('/contacto', [PortfolioController::class, 'contact'])->name('contact');
Route::post('/contacto', [ContactController::class, 'submit'])->name('contact.submit');

// Sitemap
Route::get('/sitemap.xml', [PortfolioController::class, 'sitemap']);
Route::get('/robots.txt', [PortfolioController::class, 'robots']);
```

---

## 7. Frontend — Public

### Layout: resources/views/layouts/app.blade.php
```html
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $metaTitle ?? Setting::get('site_name') }} {{ Setting::get('seo_title_suffix', '— Portfolio') }}</title>
    <meta name="description" content="{{ $metaDescription ?? Setting::get('site_description') }}">
    <meta property="og:title" content="{{ $metaTitle ?? Setting::get('site_name') }}">
    <meta property="og:description" content="{{ $metaDescription ?? Setting::get('site_description') }}">
    @isset($metaImage)<meta property="og:image" content="{{ $metaImage }}">@endisset
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>
    @include('partials.nav')
    <main id="main-content">
        {{ $slot }}
    </main>
    @include('partials.footer')
    @stack('scripts')
</body>
</html>
```

### Design System — Portfolio Contemporâneo

**Tema:** Dark, minimalista, tipografia forte. Muito espaço negativo. Grid assimétrico.

**Animações GSAP:**
```js
// Hero — Splitting.js + stagger por caracteres
document.addEventListener('DOMContentLoaded', () => {
    const results = Splitting({ target: '[data-split]', by: 'chars' });
    gsap.from('[data-split] .char', {
        y: '110%', opacity: 0, duration: 0.8,
        stagger: 0.025, ease: 'power4.out', delay: 0.3
    });
});

// Scroll animations — pattern global
gsap.utils.toArray('[data-animate]').forEach(el => {
    gsap.fromTo(el,
        { y: 80, opacity: 0 },
        { y: 0, opacity: 1, duration: 1, ease: 'power3.out',
          scrollTrigger: { trigger: el, start: 'top 88%' }
        }
    );
});

// Marquee horizontal — serviços/categorias
gsap.to('.marquee-inner', {
    xPercent: -50, ease: 'none',
    repeat: -1, duration: 20,
    modifiers: { xPercent: gsap.utils.wrap(-50, 0) }
});
```

### Páginas Públicas

**Homepage (/):**
1. **Hero** — fullscreen, título com Splitting.js, subtítulo, CTA "Ver Projetos" + "Contacto". Background: vídeo loop ou imagem com overlay escuro.
2. **Selected Work** — 4-6 projetos em destaque (is_featured), grid assimétrico com hover reveal.
3. **Marquee** — lista de categorias/serviços em loop horizontal.
4. **Sobre (snippet)** — texto curto + foto, link para /sobre.
5. **Serviços** — cards minimalistas com ícone.
6. **Testemunhos** — slider horizontal (Alpine.js).
7. **CTA Final** — "Vamos trabalhar juntos?" + botão contacto.

**Projetos (/projetos):**
- Filtros por categoria (Alpine.js client-side, sem reload).
- Grid de projetos com hover: mostra excerpt + categoria.
- Paginação ou "Carregar mais" (Alpine + fetch).

**Projeto Singular (/projetos/{slug}):**
- Hero: título + categoria + client + year + link externo.
- Galeria de fotos: grid masonry ou slider lightbox (Alpine).
- Vídeos embeds: iframes YouTube/Vimeo responsivos.
- Vídeos ficheiros: `<video>` tag com controls.
- Descrição formatada (HTML).
- Navegação: projecto anterior / próximo.

**Sobre (/sobre):**
- Bio, skills, timeline de experiência.
- Botão download CV (setting: about_cv_url).

**Contacto (/contacto):**
- Form: name, email, subject, message.
- Honeypot anti-spam (campo oculto).
- Rate limit: `throttle:5,1` no POST route.
- Guarda em `contact_messages` + envia email de notificação.
- Feedback visual Alpine.js (success/error sem reload).

---

## 8. ContactController

```php
<?php
namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageReceived;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Honeypot check
        if ($request->filled('website')) {
            return response()->json(['success' => true]); // silencioso
        }

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($validated);

        try {
            Mail::to(Setting::get('contact_email'))->send(new ContactMessageReceived($validated));
        } catch (\Exception $e) {
            // Não bloquear o utilizador se email falhar; logar apenas
            logger()->error('Contact mail failed: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Mensagem enviada com sucesso!']);
    }
}
```

---

## 9. SEO

- Meta tags dinâmicos por página (title, description, og:*)
- Schema.org JSON-LD:
  - Homepage: `Person` ou `Organization`
  - Projeto: `CreativeWork`
  - Blog post: `BlogPosting`
- Sitemap via spatie/laravel-sitemap
- robots.txt: allow all, disallow /admin
- `<link rel="canonical">` em todas as páginas
- Alt text obrigatório em todas as imagens
- Heading hierarchy: único `h1` por página

---

## 10. Seeder — Dados Demo

O seeder deve criar um portfolio funcional imediatamente após `php artisan migrate:fresh --seed`.

**DatabaseSeeder** chama nesta ordem:
1. `UserSeeder` — admin@portfolio.pt / password
2. `SettingSeeder` — todas as keys com valores realistas PT
3. `CategorySeeder` — Web Design, Desenvolvimento, Branding, Motion, Fotografia
4. `ProjectSeeder` — 8-10 projetos com dados realistas, mix de fotos e video_embeds
5. `ServiceSeeder` — 4-6 serviços
6. `TestimonialSeeder` — 4-5 testemunhos PT
7. `PostSeeder` — 4 posts publicados

**ProjectSeeder — nota sobre media:**
Usar `addMediaFromUrl()` para fotos de demonstração via Unsplash ou Pexels:
```php
$project->addMediaFromUrl('https://images.pexels.com/photos/196644/pexels-photo-196644.jpeg')
        ->toMediaCollection('cover');
```
Os `video_embeds` podem ser IDs de vídeos públicos YouTube/Vimeo.

---

## 11. Deploy Checklist (Forge + Hetzner)

### Deploy Script do Forge — COMPLETO
```bash
cd /home/forge/portfolio

# Zero-downtime: garantir storage partilhado
if [ ! -d /home/forge/portfolio/shared/storage ]; then
    mkdir -p /home/forge/portfolio/shared/storage
fi

# Symlink de storage persistente (sobrescreve release symlink)
ln -sfn /home/forge/portfolio/shared/storage /home/forge/portfolio/current/storage
rm -f /home/forge/portfolio/current/public/storage
ln -sfn /home/forge/portfolio/shared/storage/app/public /home/forge/portfolio/current/public/storage

# Dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
npm ci && npm run build

# Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force   # ← --force OBRIGATÓRIO em produção
php artisan queue:restart
```

### PHP Config (Forge)
- PHP 8.2+
- `upload_max_filesize = 64M`
- `post_max_size = 64M`
- `max_execution_time = 120`

### Nginx extra (para vídeos grandes)
```nginx
client_max_body_size 100M;
```

---

## 12. Performance

- `loading="lazy"` em todas as imagens excepto above-fold
- `srcset` e `sizes` para imagens responsivas (Spatie MediaLibrary conversions)
- Google Fonts com `font-display: swap` + `<link rel="preload">`
- Tailwind CSS purge (automático no Vite)
- GSAP tree-shaking (importar só plugins usados)
- `Cache::remember()` para settings, projetos featured, serviços (TTL 30-60min)
- Alpine.js `x-cloak` para evitar flash de conteúdo não inicializado

---

## 13. Ficheiros a Gerar (ordem de execução)

Quando pedido para gerar o projecto completo, seguir esta ordem:

1. `database/migrations/` — todas as migrations
2. `app/Models/` — todos os models
3. `config/` e `.env.example`
4. `app/Filament/Resources/` — todos os resources
5. `app/Http/Controllers/` — PortfolioController + ContactController
6. `routes/web.php`
7. `resources/views/layouts/` + partials (nav, footer)
8. `resources/views/` — todas as páginas públicas
9. `resources/css/app.css` + `resources/js/app.js`
10. `database/seeders/` — todos os seeders
11. `app/Mail/ContactMessageReceived.php`
12. `README.md` com setup e deploy

Para detalhes de cada secção, ver `references/`:
- `filament-resources.md` — código completo dos Resources
- `frontend-pages.md` — código completo das views Blade
- `deploy-forge.md` — configuração detalhada do Forge
