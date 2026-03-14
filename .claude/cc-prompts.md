# Portfolio Thiago Rodrigues — Claude Code Prompts Completos
> Cada prompt é colado diretamente no Claude Code após `claude --dangerously-skip-permissions`
> Espera SEMPRE que o Claude Code termine antes de avançar para o próximo

---

## PRÉ-REQUISITO — Fora do Claude Code (terminal normal)

```bash
# 1. Cria o projeto Laravel
laravel new thgo-portfolio
cd thgo-portfolio

# 2. PHP packages
composer require \
  filament/filament:"^3.3" \
  spatie/laravel-medialibrary \
  spatie/laravel-sluggable \
  spatie/laravel-sitemap \
  intervention/image-laravel

# 3. Instala Filament
php artisan filament:install --panels
# Quando perguntar o path do painel: aceita o default "admin"

# 4. Publica migrations do Spatie MediaLibrary
php artisan vendor:publish \
  --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" \
  --tag="medialibrary-migrations"

# 5. JS packages
npm install alpinejs gsap @studio-freight/lenis splitting

# 6. Cria a base de dados local
mysql -u root -e "CREATE DATABASE thgo_portfolio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 7. Copia os skill files para .claude/
mkdir -p .claude/references
# Copia o conteúdo dos teus ficheiros de skill:
# .claude/SKILL.md
# .claude/references/filament-resources.md
# .claude/references/frontend-pages.md
# .claude/references/deploy-forge.md

# 8. Abre no Claude Code
claude --dangerously-skip-permissions
```

---

## PROMPT 1 — .env + Configuração Base

```
Read the file .claude/SKILL.md now before doing anything else.

Configure o projeto com os seguintes ficheiros:

1. Edita .env com estes valores exactos:
APP_NAME="Thiago Rodrigues"
APP_ENV=local
APP_KEY=  (deixa em branco — será gerado pelo artisan)
APP_DEBUG=true
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=thgo_portfolio
DB_USERNAME=root
DB_PASSWORD=
FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync
CACHE_STORE=file
SESSION_DRIVER=file
MAIL_MAILER=log

2. Gera a APP_KEY:
   php artisan key:generate

3. Cria tailwind.config.js na raiz:
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/Filament/**/*.php',
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
                body:    ['Inter', 'sans-serif'],
            },
        },
    },
    plugins: [],
};

4. Substitui resources/css/app.css pelo seguinte conteúdo completo:
@tailwind base;
@tailwind components;
@tailwind utilities;

@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap');

@layer base {
    :root {
        --color-bg:         #0A0A0A;
        --color-bg-alt:     #111111;
        --color-bg-card:    #161616;
        --color-text:       #F0F0F0;
        --color-text-muted: #888888;
        --color-accent:     #E8FF47;
        --color-accent-dark:#c8df2a;
        --color-border:     #222222;
        --font-heading: 'Syne', sans-serif;
        --font-body:    'Inter', sans-serif;
    }
    html { @apply bg-[var(--color-bg)] text-[var(--color-text)] antialiased; }
    body { font-family: var(--font-body); cursor: none; }
    h1,h2,h3,h4,h5 { font-family: var(--font-heading); }
    * { cursor: none !important; }
    @media (hover: none) { *, body { cursor: auto !important; } }
}

/* Cursor personalizado */
.cursor-dot {
    width: 6px; height: 6px;
    background: var(--color-accent);
    border-radius: 50%; position: fixed;
    pointer-events: none; z-index: 9999;
    top: 0; left: 0; transform: translate(-50%,-50%);
    transition: opacity 0.3s;
}
.cursor-ring {
    width: 36px; height: 36px;
    border: 1.5px solid var(--color-accent);
    border-radius: 50%; position: fixed;
    pointer-events: none; z-index: 9998;
    top: 0; left: 0; transform: translate(-50%,-50%);
    transition: width 0.25s, height 0.25s, opacity 0.3s;
    opacity: 0.6;
}
.cursor-ring.is-hovering { width: 56px; height: 56px; opacity: 0.3; }
@media (hover: none) { .cursor-dot, .cursor-ring { display: none; } }

/* Scroll progress */
#scroll-progress {
    position: fixed; top: 0; left: 0; height: 2px;
    background: var(--color-accent); z-index: 9999;
    transform-origin: left; transform: scaleX(0);
    pointer-events: none;
}

/* Splitting.js chars */
.char { display: inline-block; overflow: hidden; }

/* Page transition */
#main-content { transition: opacity 0.3s ease; }

/* Prose para case studies */
.prose-portfolio h2 {
    font-family: var(--font-heading); font-size: 1.75rem;
    font-weight: 700; margin-top: 3rem; margin-bottom: 1rem;
    color: var(--color-text);
}
.prose-portfolio h3 {
    font-family: var(--font-heading); font-size: 1.25rem;
    font-weight: 600; color: var(--color-accent);
    margin-top: 2rem; margin-bottom: 0.75rem;
}
.prose-portfolio h4 {
    font-family: var(--font-heading); font-size: 1rem;
    font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.5rem;
    color: var(--color-text-muted);
}
.prose-portfolio p { margin-bottom: 1.25rem; line-height: 1.8; color: var(--color-text-muted); }
.prose-portfolio ul { margin-bottom: 1.25rem; padding-left: 1.5rem; }
.prose-portfolio ul li { margin-bottom: 0.5rem; color: var(--color-text-muted); line-height: 1.7; }
.prose-portfolio ul li::marker { color: var(--color-accent); }
.prose-portfolio blockquote {
    border-left: 3px solid var(--color-accent);
    padding: 1rem 1.5rem; margin: 2rem 0;
    background: var(--color-bg-card); border-radius: 0 8px 8px 0;
    font-style: italic; color: var(--color-text-muted);
}
.prose-portfolio a { color: var(--color-accent); }
.prose-portfolio strong { color: var(--color-text); font-weight: 600; }

5. Substitui resources/js/app.js pelo seguinte conteúdo completo:
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
const lenis = new Lenis({
    duration: 1.2,
    easing: t => Math.min(1, 1.001 - Math.pow(2, -10 * t))
});
lenis.on('scroll', ScrollTrigger.update);
gsap.ticker.add(time => lenis.raf(time * 1000));
gsap.ticker.lagSmoothing(0);

// Cursor personalizado
const dot  = document.querySelector('.cursor-dot');
const ring = document.querySelector('.cursor-ring');
if (dot && ring) {
    const moveDot  = gsap.quickTo(dot,  'x', { duration: 0.15, ease: 'power3' });
    const moveDotY = gsap.quickTo(dot,  'y', { duration: 0.15, ease: 'power3' });
    const moveRing  = gsap.quickTo(ring, 'x', { duration: 0.5, ease: 'power3' });
    const moveRingY = gsap.quickTo(ring, 'y', { duration: 0.5, ease: 'power3' });
    window.addEventListener('mousemove', e => {
        moveDot(e.clientX); moveDotY(e.clientY);
        moveRing(e.clientX); moveRingY(e.clientY);
    });
    document.querySelectorAll('a, button').forEach(el => {
        el.addEventListener('mouseenter', () => ring.classList.add('is-hovering'));
        el.addEventListener('mouseleave', () => ring.classList.remove('is-hovering'));
    });
}

// Scroll progress bar
gsap.to('#scroll-progress', {
    scaleX: 1, ease: 'none',
    scrollTrigger: { trigger: document.body, start: 'top top', end: 'bottom bottom', scrub: true }
});

// Animações globais scroll
document.addEventListener('DOMContentLoaded', () => {
    gsap.utils.toArray('[data-animate]').forEach(el => {
        gsap.fromTo(el,
            { y: 60, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.9, ease: 'power3.out',
              scrollTrigger: { trigger: el, start: 'top 88%' } }
        );
    });
});

// Page transitions
document.querySelectorAll('a[href]').forEach(a => {
    if (a.hostname === location.hostname && !a.hasAttribute('target') && !a.href.includes('/admin')) {
        a.addEventListener('click', e => {
            const href = a.href;
            if (!href.includes('#')) {
                e.preventDefault();
                gsap.to('#main-content', {
                    opacity: 0, y: -16, duration: 0.22, ease: 'power2.in',
                    onComplete: () => { window.location.href = href; }
                });
            }
        });
    }
});

Alpine.start();

6. Verifica que vite.config.js tem:
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
export default defineConfig({
    plugins: [laravel({ input: ['resources/css/app.css', 'resources/js/app.js'], refresh: true })],
});

Depois de criar todos os ficheiros, corre:
php artisan config:clear
npm run build
```

---

## PROMPT 2 — Migrations

```
Read .claude/SKILL.md section "5. Migrations" before starting.

Cria TODAS as migrations na pasta database/migrations/ nesta ordem exacta.
Apaga primeiro qualquer migration de users/password_resets que já exista e mantém apenas a de users original do Laravel.

MIGRATION 1 — create_settings_table:
Schema::create('settings', function (Blueprint $table) {
    $table->id();
    $table->string('key')->unique();
    $table->text('value')->nullable();
    $table->timestamps();
});

MIGRATION 2 — create_categories_table:
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->string('color', 7)->nullable();
    $table->integer('sort_order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});

MIGRATION 3 — create_projects_table:
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

MIGRATION 4 — create_services_table:
Schema::create('services', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->string('icon')->nullable();
    $table->integer('sort_order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});

MIGRATION 5 — create_testimonials_table:
Schema::create('testimonials', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('role')->nullable();
    $table->string('company')->nullable();
    $table->text('content');
    $table->string('avatar')->nullable();
    $table->tinyInteger('rating')->default(5);
    $table->boolean('is_active')->default(true);
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});

MIGRATION 6 — create_posts_table:
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->string('excerpt')->nullable();
    $table->longText('content')->nullable();
    $table->string('cover')->nullable();
    $table->boolean('is_published')->default(false);
    $table->timestamp('published_at')->nullable();
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();
    $table->integer('sort_order')->default(0);
    $table->softDeletes();
    $table->timestamps();
});

MIGRATION 7 — create_contact_messages_table:
Schema::create('contact_messages', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email');
    $table->string('subject')->nullable();
    $table->text('message');
    $table->boolean('is_read')->default(false);
    $table->timestamps();
});

Depois de criar todas as migrations, corre:
php artisan migrate

Se houver erros de "table already exists", corre:
php artisan migrate:fresh
```

---

## PROMPT 3 — Models

```
Read .claude/SKILL.md section "3. Models" before starting.

Cria os seguintes models em app/Models/:

1. app/Models/Setting.php — exactamente:
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, $default = null): mixed
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}

2. app/Models/Category.php:
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasSlug;
    protected $fillable = ['name', 'slug', 'color', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }

    public function projects() { return $this->hasMany(Project::class); }
    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}

3. app/Models/Project.php:
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
        'title','slug','excerpt','description','client','url',
        'year','category_id','is_featured','is_active',
        'sort_order','meta_title','meta_description','video_embeds',
    ];
    protected $casts = [
        'is_featured'  => 'boolean',
        'is_active'    => 'boolean',
        'video_embeds' => 'array',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function category() { return $this->belongsTo(Category::class); }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('videos');
    }

    public function getCoverUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('cover') ?: asset('images/placeholder.jpg');
    }

    public function scopeActive($q)    { return $q->where('is_active', true); }
    public function scopeFeatured($q)  { return $q->where('is_featured', true); }
    public function scopeOrdered($q)   { return $q->orderBy('sort_order')->orderByDesc('year'); }
}

4. app/Models/Service.php:
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Service extends Model
{
    use HasSlug;
    protected $fillable = ['title','slug','description','icon','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];
    public function getSlugOptions(): SlugOptions {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }
    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}

5. app/Models/Testimonial.php:
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name','role','company','content','avatar','rating','is_active','sort_order'];
    protected $casts = ['is_active' => 'boolean'];
    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}

6. app/Models/Post.php:
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use SoftDeletes, HasSlug;
    protected $fillable = ['title','slug','excerpt','content','cover','is_published','published_at','meta_title','meta_description','sort_order'];
    protected $casts = ['is_published' => 'boolean', 'published_at' => 'datetime'];
    public function getSlugOptions(): SlugOptions {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug')->doNotGenerateSlugsOnUpdate();
    }
    public function scopePublished($q) { return $q->where('is_published', true)->orderByDesc('published_at'); }
}

7. app/Models/ContactMessage.php:
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = ['name','email','subject','message','is_read'];
    protected $casts = ['is_read' => 'boolean'];
}

Depois de criar os models, cria também uma imagem placeholder:
- Pasta: public/images/
- Ficheiro: public/images/placeholder.jpg (pode ser qualquer imagem 1x1 pixel ou copiar uma existente)

Verifica os models com:
php artisan tinker
>>> App\Models\Setting::get('test', 'works')
>>> exit
```

---

## PROMPT 4 — Filament Admin Resources

```
Read .claude/SKILL.md section "4. Filament Admin Panel" AND read the full file .claude/references/filament-resources.md before starting.

Cria todos os Filament Resources e Pages seguindo exactamente o código em .claude/references/filament-resources.md.

LISTA COMPLETA de ficheiros a criar:

1. app/Filament/Resources/CategoryResource.php
   - navigationGroup: 'Portfolio', sort: 2
   - Form: TextInput name (required), ColorPicker color, Toggle is_active, TextInput sort_order
   - Table: name (badge com color), slug, sort_order, ToggleColumn is_active
   - Pages: List, Create, Edit

2. app/Filament/Resources/CategoryResource/Pages/ListCategories.php
   app/Filament/Resources/CategoryResource/Pages/CreateCategory.php
   app/Filament/Resources/CategoryResource/Pages/EditCategory.php

3. app/Filament/Resources/ProjectResource.php — usa o código COMPLETO de .claude/references/filament-resources.md
   - navigationGroup: 'Portfolio', sort: 1
   - Tabs: Geral | Média (com SpatieMediaLibraryFileUpload cover + gallery + videos + Repeater video_embeds) | SEO
   - Table com SpatieMediaLibraryImageColumn, toggles, filters, reorderable
   - SoftDelete support (Restore + ForceDelete actions)

4. app/Filament/Resources/ProjectResource/Pages/ListProjects.php
   app/Filament/Resources/ProjectResource/Pages/CreateProject.php
   app/Filament/Resources/ProjectResource/Pages/EditProject.php

5. app/Filament/Resources/ServiceResource.php
   - navigationGroup: 'Conteúdo', sort: 1
   - Form: title, slug (auto), description (Textarea), icon (TextInput), sort_order, is_active

6. app/Filament/Resources/ServiceResource/Pages/ (List, Create, Edit)

7. app/Filament/Resources/TestimonialResource.php
   - navigationGroup: 'Conteúdo', sort: 2
   - Form: name, role, company, content (Textarea, rows 4), FileUpload avatar (disk public, dir testimonials), rating (Select 1-5), is_active, sort_order

8. app/Filament/Resources/TestimonialResource/Pages/ (List, Create, Edit)

9. app/Filament/Resources/PostResource.php
   - navigationGroup: 'Conteúdo', sort: 3
   - Form: title, slug, excerpt, RichEditor content, FileUpload cover (disk public), is_published, DateTimePicker published_at, meta_title, meta_description

10. app/Filament/Resources/PostResource/Pages/ (List, Create, Edit)

11. app/Filament/Resources/ContactMessageResource.php — usa o código de .claude/references/filament-resources.md
    - navigationGroup: 'Contacto'
    - Read-only (canCreate: false)
    - Badge com count de não lidas
    - Action 'markRead' + ViewAction + DeleteAction

12. app/Filament/Resources/ContactMessageResource/Pages/ListContactMessages.php

13. app/Filament/Pages/Settings.php — usa o código COMPLETO de .claude/references/filament-resources.md
    - Página customizada (não é Resource)
    - Tabs: Geral | Redes Sociais | Homepage | Sobre | SEO
    - Método save() com Setting::set() para cada campo

14. resources/views/filament/pages/settings.blade.php:
<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}
        <div class="mt-6">
            <x-filament::button type="submit">Guardar Definições</x-filament::button>
        </div>
    </form>
</x-filament-panels::page>

Depois de criar todos os ficheiros, cria o utilizador admin:
php artisan make:filament-user
# Name: Thiago Rodrigues
# Email: admin@thgo.me
# Password: password

Verifica que o admin carrega sem erros:
php artisan route:list | grep admin
```

---

## PROMPT 5 — Controllers, Routes, Mail

```
Read .claude/SKILL.md section "6. Routes" and section "8. ContactController" before starting.

Cria os seguintes ficheiros:

1. app/Http/Controllers/PortfolioController.php — completo:
<?php
namespace App\Http\Controllers;

use App\Models\{Category, Post, Project, Service, Setting, Testimonial};
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function home()
    {
        return view('home', [
            'featuredProjects' => Project::active()->featured()->ordered()->with('category')->limit(5)->get(),
            'categories'       => Category::active()->get(),
            'services'         => Service::active()->limit(6)->get(),
            'testimonials'     => Testimonial::active()->limit(5)->get(),
        ]);
    }

    public function projects()
    {
        return view('projects', [
            'projects'   => Project::active()->ordered()->with('category')->get(),
            'categories' => Category::active()->get(),
        ]);
    }

    public function project(Project $project)
    {
        abort_if(!$project->is_active, 404);
        $ordered = Project::active()->ordered()->pluck('id');
        $currentIndex = $ordered->search($project->id);
        return view('project', [
            'project'  => $project->load('category'),
            'previous' => $currentIndex > 0 ? Project::find($ordered[$currentIndex - 1]) : null,
            'next'     => $currentIndex < $ordered->count() - 1 ? Project::find($ordered[$currentIndex + 1]) : null,
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function blog()
    {
        return view('blog', [
            'posts'      => Post::published()->paginate(9),
            'categories' => Category::active()->get(),
        ]);
    }

    public function post(Post $post)
    {
        abort_if(!$post->is_published, 404);
        return view('post', ['post' => $post]);
    }

    public function sitemap()
    {
        $projects = Project::active()->ordered()->get();
        $posts    = Post::published()->get();
        return response()->view('sitemap', compact('projects', 'posts'))
            ->header('Content-Type', 'application/xml');
    }
}

2. app/Http/Controllers/ContactController.php — exactamente:
<?php
namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function submit(Request $request): JsonResponse
    {
        // Honeypot
        if ($request->filled('website')) {
            return response()->json(['success' => true]);
        }

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($validated);

        try {
            \Mail::to(Setting::get('contact_email', 'hello@thgo.me'))
                ->send(new \App\Mail\ContactMessageReceived($validated));
        } catch (\Exception $e) {
            logger()->error('Mail failed: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Message sent successfully!']);
    }
}

3. app/Mail/ContactMessageReceived.php:
<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function build()
    {
        return $this->subject('New contact message: ' . ($this->data['subject'] ?? 'No subject'))
            ->html(
                '<h2>New message from ' . e($this->data['name']) . '</h2>' .
                '<p><strong>Email:</strong> ' . e($this->data['email']) . '</p>' .
                '<p><strong>Message:</strong></p><p>' . nl2br(e($this->data['message'])) . '</p>'
            );
    }
}

4. Substitui routes/web.php por:
<?php
use App\Http\Controllers\{PortfolioController, ContactController};
use Illuminate\Support\Facades\Route;

Route::get('/',           [PortfolioController::class, 'home'])->name('home');
Route::get('/work',       [PortfolioController::class, 'projects'])->name('projects');
Route::get('/work/{project:slug}', [PortfolioController::class, 'project'])->name('project');
Route::get('/about',      [PortfolioController::class, 'about'])->name('about');
Route::get('/contact',    [PortfolioController::class, 'contact'])->name('contact');
Route::post('/contact',   [ContactController::class,   'submit'])->name('contact.submit')
     ->middleware('throttle:5,1');
Route::get('/blog',       [PortfolioController::class, 'blog'])->name('blog');
Route::get('/blog/{post:slug}', [PortfolioController::class, 'post'])->name('post');
Route::get('/sitemap.xml',[PortfolioController::class, 'sitemap']);

5. Cria resources/views/sitemap.blade.php:
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ url('/') }}</loc><changefreq>weekly</changefreq><priority>1.0</priority></url>
    <url><loc>{{ url('/work') }}</loc><changefreq>weekly</changefreq><priority>0.9</priority></url>
    <url><loc>{{ url('/about') }}</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>
    <url><loc>{{ url('/contact') }}</loc><changefreq>monthly</changefreq><priority>0.7</priority></url>
    @foreach($projects as $p)
    <url><loc>{{ url('/work/'.$p->slug) }}</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>
    @endforeach
    @foreach($posts as $p)
    <url><loc>{{ url('/blog/'.$p->slug) }}</loc><changefreq>monthly</changefreq><priority>0.6</priority></url>
    @endforeach
</urlset>

6. Cria public/robots.txt:
User-agent: *
Allow: /
Disallow: /admin
Sitemap: {{ url('/sitemap.xml') }}

Verifica as rotas:
php artisan route:list --columns=method,uri,name
```

---

## PROMPT 6 — Layout, Nav, Footer

```
Read .claude/references/frontend-pages.md section "Nav" and the layout section before starting.

Cria os seguintes ficheiros de layout:

1. resources/views/layouts/app.blade.php — layout principal completo:
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $metaTitle ?? '' }} {{ $metaTitle ? '—' : '' }} {{ \App\Models\Setting::get('site_name', 'Thiago Rodrigues') }} {{ \App\Models\Setting::get('seo_title_suffix', '· Product Designer') }}</title>
    <meta name="description" content="{{ $metaDescription ?? \App\Models\Setting::get('site_description', '') }}">
    <meta property="og:title" content="{{ $metaTitle ?? \App\Models\Setting::get('site_name') }}">
    <meta property="og:description" content="{{ $metaDescription ?? \App\Models\Setting::get('site_description') }}">
    @isset($metaImage)<meta property="og:image" content="{{ $metaImage }}">@endisset
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')

    @if(\App\Models\Setting::get('google_analytics_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ \App\Models\Setting::get('google_analytics_id') }}"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}gtag('js',new Date());gtag('config','{{ \App\Models\Setting::get('google_analytics_id') }}');</script>
    @endif

    @isset($schemaOrg)
    <script type="application/ld+json">{!! json_encode($schemaOrg) !!}</script>
    @endisset
</head>
<body class="bg-[var(--color-bg)] text-[var(--color-text)] antialiased">
    <div id="scroll-progress"></div>
    <div class="cursor-dot"></div>
    <div class="cursor-ring"></div>
    @include('partials.nav')
    <main id="main-content">
        {{ $slot }}
    </main>
    @include('partials.footer')
    @stack('scripts')
</body>
</html>

2. resources/views/partials/nav.blade.php — exactamente:
<header id="site-nav" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        x-data="{ open: false, scrolled: false }"
        x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 60)"
        :class="scrolled ? 'bg-[var(--color-bg)]/95 backdrop-blur-sm border-b border-[var(--color-border)]' : ''">
    <nav class="container mx-auto px-6 py-5 flex items-center justify-between">
        <a href="{{ route('home') }}" class="font-heading font-bold text-xl tracking-tight">
            TR<span class="text-[var(--color-accent)]">.</span>
        </a>
        <ul class="hidden md:flex items-center gap-8 text-sm font-medium">
            <li><a href="{{ route('projects') }}" class="text-[var(--color-text-muted)] hover:text-[var(--color-text)] transition-colors">Work</a></li>
            <li><a href="{{ route('about') }}" class="text-[var(--color-text-muted)] hover:text-[var(--color-text)] transition-colors">About</a></li>
            <li>
                <span class="flex items-center gap-2 text-[var(--color-text-muted)] text-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse inline-block"></span>
                    Available 2026
                </span>
            </li>
            <li>
                <a href="{{ route('contact') }}"
                   class="bg-[var(--color-accent)] text-[var(--color-bg)] font-semibold px-5 py-2 rounded-full text-sm hover:bg-[var(--color-accent-dark)] transition-colors">
                    Let's talk
                </a>
            </li>
        </ul>
        <button @click="open = !open" class="md:hidden flex flex-col gap-1.5 p-2 z-50" aria-label="Menu">
            <span :class="open ? 'rotate-45 translate-y-2' : ''" class="block w-6 h-0.5 bg-current transition-transform duration-300 origin-center"></span>
            <span :class="open ? 'opacity-0' : ''" class="block w-6 h-0.5 bg-current transition-opacity duration-300"></span>
            <span :class="open ? '-rotate-45 -translate-y-2' : ''" class="block w-6 h-0.5 bg-current transition-transform duration-300 origin-center"></span>
        </button>
    </nav>
    <div x-show="open"
         x-transition:enter="transition duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:leave="transition duration-150"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden fixed inset-0 bg-[var(--color-bg)] z-40 flex flex-col justify-center px-8">
        <ul class="flex flex-col gap-8">
            <li><a href="{{ route('projects') }}" @click="open=false" class="font-heading font-bold text-5xl">Work</a></li>
            <li><a href="{{ route('about') }}" @click="open=false" class="font-heading font-bold text-5xl">About</a></li>
            <li><a href="{{ route('blog') }}" @click="open=false" class="font-heading font-bold text-5xl">Blog</a></li>
            <li><a href="{{ route('contact') }}" @click="open=false" class="font-heading font-bold text-5xl text-[var(--color-accent)]">Contact</a></li>
        </ul>
    </div>
</header>

3. resources/views/partials/footer.blade.php:
<footer class="border-t border-[var(--color-border)] py-12 mt-32">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <p class="text-[var(--color-text-muted)] text-sm font-heading italic">
                "Designing products that matter."
            </p>
            <div class="flex items-center gap-6">
                @if(\App\Models\Setting::get('social_linkedin'))
                <a href="{{ \App\Models\Setting::get('social_linkedin') }}" target="_blank" rel="noopener noreferrer"
                   class="text-[var(--color-text-muted)] hover:text-[var(--color-accent)] transition-colors text-sm font-medium">
                    LinkedIn
                </a>
                @endif
                @if(\App\Models\Setting::get('social_github'))
                <a href="{{ \App\Models\Setting::get('social_github') }}" target="_blank" rel="noopener noreferrer"
                   class="text-[var(--color-text-muted)] hover:text-[var(--color-accent)] transition-colors text-sm font-medium">
                    GitHub
                </a>
                @endif
                @if(\App\Models\Setting::get('social_behance'))
                <a href="{{ \App\Models\Setting::get('social_behance') }}" target="_blank" rel="noopener noreferrer"
                   class="text-[var(--color-text-muted)] hover:text-[var(--color-accent)] transition-colors text-sm font-medium">
                    Behance
                </a>
                @endif
            </div>
            <p class="text-[var(--color-text-muted)] text-xs">
                © {{ date('Y') }} Thiago Rodrigues
            </p>
        </div>
    </div>
</footer>
```

---

## PROMPT 7 — Homepage

```
Read .claude/references/frontend-pages.md section "Homepage" before starting.

Cria resources/views/home.blade.php com o seguinte conteúdo completo:

<x-app-layout>

{{-- HERO --}}
<section class="relative min-h-screen flex flex-col justify-end pb-24 overflow-hidden">
    <div class="container mx-auto px-6 relative z-10">
        <p class="text-[var(--color-accent)] font-mono text-xs tracking-[0.25em] uppercase mb-8 opacity-0"
           data-hero-tag>
            Product Designer · 10+ years · PT / US / UK
        </p>
        <h1 class="font-heading font-extrabold leading-none mb-8 text-[clamp(72px,11vw,180px)]" data-split>
            {!! nl2br(e(\App\Models\Setting::get('hero_title', "Product\nDesigner."))) !!}
        </h1>
        <p class="text-[var(--color-text-muted)] text-xl max-w-lg mb-12 opacity-0" data-hero-sub>
            {{ \App\Models\Setting::get('hero_subtitle', 'Turning complex challenges into clear, purposeful digital products.') }}
        </p>
        <div class="flex flex-wrap items-center gap-4 mb-16 opacity-0" data-hero-cta>
            <a href="{{ route('projects') }}"
               class="bg-[var(--color-accent)] text-[var(--color-bg)] font-semibold px-8 py-4 rounded-full hover:bg-[var(--color-accent-dark)] transition-colors">
                View Work
            </a>
            <a href="{{ route('contact') }}"
               class="border border-[var(--color-border)] text-[var(--color-text)] font-semibold px-8 py-4 rounded-full hover:border-[var(--color-text)] transition-colors">
                Get in touch
            </a>
        </div>
        <div class="flex flex-wrap gap-6 text-[var(--color-text-muted)] text-xs font-mono opacity-0" data-hero-tag>
            <span>10+ yrs experience</span>
            <span class="text-[var(--color-border)]">/</span>
            <span>5 industries</span>
            <span class="text-[var(--color-border)]">/</span>
            <span>2× Google Award winner</span>
        </div>
    </div>
    <div class="absolute right-0 top-1/3 w-[50vw] h-[50vw] rounded-full bg-[var(--color-accent)]/4 blur-[100px] pointer-events-none"></div>
    <div class="absolute -right-4 top-1/2 -translate-y-1/2 -rotate-90 text-[10px] tracking-[0.4em] text-[var(--color-text-muted)] opacity-20 whitespace-nowrap hidden lg:block select-none">
        THIAGO RODRIGUES — PRODUCT DESIGNER
    </div>
</section>

{{-- SELECTED WORK --}}
<section class="py-32 relative">
    <div class="container mx-auto px-6">
        <div class="relative mb-20">
            <span class="absolute -top-16 right-0 font-heading font-bold text-[clamp(80px,15vw,200px)] text-[var(--color-text)] opacity-[0.03] select-none leading-none">01</span>
            <p class="text-[var(--color-accent)] font-mono text-xs tracking-widest uppercase mb-4" data-animate>Selected Work</p>
            <div class="flex items-end justify-between">
                <h2 class="font-heading font-bold text-4xl md:text-5xl" data-animate>Cases that<br>moved the needle</h2>
                <a href="{{ route('projects') }}" class="text-[var(--color-accent)] hover:underline text-sm font-medium hidden md:block" data-animate>
                    All work →
                </a>
            </div>
        </div>

        <div class="divide-y divide-[var(--color-border)]">
            @foreach($featuredProjects as $i => $project)
            <a href="{{ route('project', $project) }}"
               class="case-row group relative flex items-center gap-6 py-8 overflow-hidden">
                <span class="text-[var(--color-text-muted)] font-mono text-sm w-8 shrink-0 hidden sm:block">
                    {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                </span>
                <h3 class="font-heading font-bold text-3xl sm:text-4xl lg:text-5xl xl:text-6xl flex-1 leading-none
                            group-hover:text-[var(--color-accent)] transition-colors duration-300">
                    {{ $project->title }}
                </h3>
                <div class="hidden lg:flex items-center gap-3 shrink-0 text-[var(--color-text-muted)] text-sm">
                    @if($project->category)<span>{{ $project->category->name }}</span>@endif
                    @if($project->client)<span class="text-[var(--color-border)]">·</span><span>{{ $project->client }}</span>@endif
                    @if($project->year)<span class="text-[var(--color-border)]">·</span><span>{{ $project->year }}</span>@endif
                </div>
                <span class="text-[var(--color-accent)] text-xl opacity-0 group-hover:opacity-100 transition-all duration-300 -translate-x-2 group-hover:translate-x-0 shrink-0">→</span>
                <div class="case-hover-image pointer-events-none absolute right-56 top-1/2 -translate-y-1/2
                            w-72 h-44 rounded-xl overflow-hidden opacity-0 group-hover:opacity-100
                            transition-all duration-500 scale-95 group-hover:scale-100 z-10 hidden xl:block">
                    <img src="{{ $project->cover_url }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                </div>
            </a>
            @endforeach
        </div>

        <div class="mt-8 md:hidden">
            <a href="{{ route('projects') }}" class="text-[var(--color-accent)] text-sm font-medium">All work →</a>
        </div>
    </div>
</section>

{{-- MARQUEE --}}
<div class="border-y border-[var(--color-border)] py-5 overflow-hidden">
    <div class="flex whitespace-nowrap">
        <span class="marquee-inner flex gap-10 pr-10 text-[var(--color-text-muted)] text-xs font-medium tracking-widest uppercase">
            @forelse($categories as $cat)
            <span>{{ $cat->name }}</span><span class="text-[var(--color-accent)]">✦</span>
            @empty
            <span>Product Design</span><span class="text-[var(--color-accent)]">✦</span>
            <span>UX Research</span><span class="text-[var(--color-accent)]">✦</span>
            <span>Design Systems</span><span class="text-[var(--color-accent)]">✦</span>
            <span>AI-augmented Workflows</span><span class="text-[var(--color-accent)]">✦</span>
            @endforelse
            @forelse($categories as $cat)
            <span>{{ $cat->name }}</span><span class="text-[var(--color-accent)]">✦</span>
            @empty
            <span>Product Design</span><span class="text-[var(--color-accent)]">✦</span>
            <span>Enterprise UX</span><span class="text-[var(--color-accent)]">✦</span>
            <span>0→1 Products</span><span class="text-[var(--color-accent)]">✦</span>
            @endforelse
        </span>
    </div>
</div>

{{-- ABOUT SNIPPET --}}
<section class="py-32">
    <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-5 gap-16 items-start">
            <div class="lg:col-span-3">
                <div class="relative">
                    <span class="absolute -top-12 -left-4 font-heading font-bold text-[clamp(60px,12vw,160px)] text-[var(--color-text)] opacity-[0.04] select-none leading-none">02</span>
                </div>
                <p class="text-[var(--color-accent)] font-mono text-xs tracking-widest uppercase mb-6" data-animate>About</p>
                <h2 class="font-heading font-bold text-4xl md:text-5xl mb-8 leading-none" data-animate>
                    {{ \App\Models\Setting::get('about_title', 'Designer. Builder. Systems thinker.') }}
                </h2>
                <p class="text-[var(--color-text-muted)] text-lg leading-relaxed mb-10 line-clamp-4" data-animate>
                    I'm Thiago Rodrigues — a Product Designer with 10+ years of experience turning complex challenges into clear, purposeful digital products.
                </p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-10" data-animate>
                    @foreach([['10+','yrs exp.'],['5','industries'],['2×','Google Award'],['3','live products']] as $stat)
                    <div class="border border-[var(--color-border)] rounded-xl p-4 text-center">
                        <p class="font-heading font-bold text-3xl text-[var(--color-accent)]">{{ $stat[0] }}</p>
                        <p class="text-[var(--color-text-muted)] text-xs mt-1">{{ $stat[1] }}</p>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('about') }}" class="inline-flex items-center gap-2 text-[var(--color-accent)] hover:underline font-medium" data-animate>
                    Read more →
                </a>
            </div>
            <div class="lg:col-span-2" data-animate>
                <div class="border-l-4 border-[var(--color-accent)] p-8 bg-[var(--color-bg-card)] rounded-r-2xl">
                    <p class="font-heading text-xl font-medium leading-relaxed italic text-[var(--color-text)] mb-6">
                        "I design what's buildable, scalable, and measurable — because I've shipped the code too."
                    </p>
                    <p class="text-[var(--color-text-muted)] text-sm font-medium">— Thiago Rodrigues</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SERVICES --}}
@if($services->count())
<section class="py-32 bg-[var(--color-bg-alt)]">
    <div class="container mx-auto px-6">
        <div class="relative mb-20">
            <span class="absolute -top-16 right-0 font-heading font-bold text-[clamp(80px,15vw,200px)] text-[var(--color-text)] opacity-[0.03] select-none leading-none">03</span>
            <p class="text-[var(--color-accent)] font-mono text-xs tracking-widest uppercase mb-4" data-animate>Services</p>
            <h2 class="font-heading font-bold text-4xl md:text-5xl" data-animate>What I do best</h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($services as $service)
            <div class="border border-[var(--color-border)] rounded-2xl p-8 hover:border-[var(--color-accent)]/50 transition-all duration-300 group" data-animate>
                @if($service->icon)
                <div class="text-[var(--color-accent)] text-3xl mb-5 group-hover:scale-110 transition-transform inline-block">{{ $service->icon }}</div>
                @endif
                <h3 class="font-heading font-semibold text-xl mb-3 group-hover:text-[var(--color-accent)] transition-colors">{{ $service->title }}</h3>
                <p class="text-[var(--color-text-muted)] text-sm leading-relaxed">{{ $service->description }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- TESTIMONIALS --}}
@if($testimonials->count())
<section class="py-32">
    <div class="container mx-auto px-6">
        <p class="text-[var(--color-accent)] font-mono text-xs tracking-widest uppercase mb-4" data-animate>Testimonials</p>
        <h2 class="font-heading font-bold text-4xl md:text-5xl mb-16" data-animate>What people say</h2>
        <div x-data="{ active: 0 }" class="relative">
            @foreach($testimonials as $i => $t)
            <div x-show="active === {{ $i }}"
                 x-transition:enter="transition duration-500"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 class="max-w-3xl">
                <p class="font-heading text-2xl md:text-3xl font-medium leading-relaxed mb-10 text-[var(--color-text)]">
                    "{{ $t->content }}"
                </p>
                <div class="flex items-center gap-4">
                    @if($t->avatar)
                    <img src="{{ asset('storage/' . $t->avatar) }}" alt="{{ $t->name }}" class="w-12 h-12 rounded-full object-cover">
                    @else
                    <div class="w-12 h-12 rounded-full bg-[var(--color-bg-card)] border border-[var(--color-border)] flex items-center justify-center font-heading font-bold text-[var(--color-accent)]">
                        {{ substr($t->name, 0, 1) }}
                    </div>
                    @endif
                    <div>
                        <p class="font-semibold text-sm">{{ $t->name }}</p>
                        @if($t->company)<p class="text-[var(--color-text-muted)] text-xs">{{ $t->role ? $t->role . ' · ' : '' }}{{ $t->company }}</p>@endif
                    </div>
                </div>
            </div>
            @endforeach
            @if($testimonials->count() > 1)
            <div class="flex gap-2 mt-12">
                @foreach($testimonials as $i => $t)
                <button @click="active = {{ $i }}"
                        :class="active === {{ $i }} ? 'bg-[var(--color-accent)] w-8' : 'bg-[var(--color-border)] w-2'"
                        class="h-2 rounded-full transition-all duration-300"></button>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- CTA FINAL --}}
<section class="py-40 text-center overflow-hidden">
    <div class="container mx-auto px-6">
        <h2 class="font-heading font-extrabold leading-none mb-6 text-[clamp(48px,8vw,130px)]" data-split>
            Let's build<br>something.
        </h2>
        <p class="text-[var(--color-text-muted)] text-xl mb-12" data-animate>
            I'm available for new projects in 2026.
        </p>
        <a href="{{ route('contact') }}"
           class="inline-block bg-[var(--color-accent)] text-[var(--color-bg)] font-heading font-bold text-xl px-12 py-6 rounded-full hover:bg-[var(--color-accent-dark)] transition-colors" data-animate>
            Start a conversation →
        </a>
        @if(\App\Models\Setting::get('contact_email'))
        <p class="text-[var(--color-text-muted)] text-sm mt-8" data-animate>
            Or email directly: <a href="mailto:{{ \App\Models\Setting::get('contact_email') }}" class="text-[var(--color-accent)] hover:underline">{{ \App\Models\Setting::get('contact_email') }}</a>
        </p>
        @endif
    </div>
    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[80vw] h-[80vw] rounded-full bg-[var(--color-accent)]/3 blur-[120px] pointer-events-none -z-10"></div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Splitting hero title
    if (window.Splitting) {
        Splitting({ target: '[data-split]', by: 'chars' });
        gsap.from('[data-split] .char', {
            y: '110%', opacity: 0, duration: 0.9,
            stagger: 0.02, ease: 'power4.out', delay: 0.2
        });
    }
    // Hero elements
    gsap.to('[data-hero-tag]', { opacity: 1, y: 0, duration: 0.6, delay: 0.1, stagger: 0.3 });
    gsap.from('[data-hero-sub]',{ y: 30, duration: 0.7, delay: 0.8, clearProps: 'all' });
    gsap.to('[data-hero-sub]', { opacity: 1, duration: 0.7, delay: 0.8 });
    gsap.from('[data-hero-cta]',{ y: 20, duration: 0.7, delay: 1.0, clearProps: 'all' });
    gsap.to('[data-hero-cta]', { opacity: 1, duration: 0.7, delay: 1.0 });

    // Case rows reveal
    gsap.utils.toArray('.case-row').forEach((row, i) => {
        gsap.fromTo(row,
            { clipPath: 'inset(0 0 100% 0)', opacity: 0 },
            { clipPath: 'inset(0 0 0% 0)', opacity: 1, duration: 0.7,
              ease: 'power3.out', delay: i * 0.07,
              scrollTrigger: { trigger: row, start: 'top 90%' } }
        );
    });

    // Marquee
    if (document.querySelector('.marquee-inner')) {
        gsap.to('.marquee-inner', {
            xPercent: -50, ease: 'none', repeat: -1, duration: 25,
            modifiers: { xPercent: gsap.utils.wrap(-50, 0) }
        });
    }
});
</script>
@endpush
</x-app-layout>
```

---

## PROMPT 8 — Páginas Work, Project, About, Contact

```
Read .claude/references/frontend-pages.md sections "Projetos", "Projeto Singular", "Contacto" before starting.

Cria os seguintes 4 ficheiros de views:

1. resources/views/projects.blade.php — página Work com lista editorial e filtros Alpine
2. resources/views/project.blade.php — case study singular com hero full-viewport, galeria lightbox, vídeos, navegação prev/next
3. resources/views/about.blade.php — com hero data-split, recognition (2 Google awards), skills (3 grupos), timeline completa (8 entradas), educação (IADE + CCT Dublin), idiomas
4. resources/views/contact.blade.php — layout split, Alpine.js form, honeypot, feedback visual

Para cada vista, segue o padrão do .claude/references/frontend-pages.md mas com estas especificidades:

WORK (projects.blade.php):
- h1 com data-split: "Work" — text-[clamp(80px,14vw,200px)] font-heading extrabold leading-none
- Filtros Alpine: pills com active state accent, filtro client-side sem reload
- Lista editorial idêntica à homepage (case-row com número, título grande, hover image)
- Para mobile: grid 2 colunas com cards normais

PROJECT (project.blade.php):
- Hero: min-h-[80vh] flex flex-col justify-end, background com cover image full-bleed + gradient overlay escuro (from-transparent to-[var(--color-bg)] via-[var(--color-bg)]/60)
- Cover image abaixo do hero: w-full aspect-video object-cover sem container lateral
- Description: prose-portfolio class (definida no CSS), max-w-3xl mx-auto px-6
- Galeria: grid-cols-2 md:grid-cols-3, primeiro item col-span-2 row-span-2, lightbox Alpine.js
- Navegação prev/next: full-width, duas colunas
- CTA final: "Have a similar challenge? Let's talk."
- GSAP: Splitting hero + scroll reveals + parallax cover (yPercent: 20, scrub: true)

ABOUT (about.blade.php):
- Hero data-split: "Designer.\nBuilder.\nSystems thinker." em 3 linhas separadas
- Recognition section: bg-alt, 2 cards Google awards (conteúdo real já definido no PROMPT 7 atualizado)
- Skills: 3 grupos (Foundation 10+yrs / Process & Tools 5+yrs / AI & Technical Growing fast)
- Timeline: 8 entradas com as datas e empresas reais (McKesson, BladeInsight, MindTools, Montepascual, Progress Systems, Granber, Independent, Edson Queiroz Group)
- Educação: IADE 2022-2023 + College of Computing Technology Dublin 2015-2018
- Idiomas: PT (Native) / EN (C1) / ES (B1)

CONTACT (contact.blade.php):
- Split lg:grid-cols-2
- Esquerda: h1 data-split "Let's build\nsomething.", disponibilidade (dot verde pulse + "Available for new projects — 2026"), email directo, "Based in Portugal (WET/UTC+0)"
- Direita: Alpine form com contactForm() function, honeypot input name="website", success/error states
- Alpine JS contactForm(): fetch POST /contact com CSRF, JSON body, feedback sem reload

Cria também:
5. resources/views/blog.blade.php — grid simples de posts com cover, title, excerpt, date
6. resources/views/post.blade.php — singular com título, cover, prose content, prev/next

Verifica que todas as views carregam sem erros de Blade/Alpine executando:
php artisan route:list
php artisan view:clear
```

---

## PROMPT 9 — Seeders com Conteúdo Real

```
Read the file "portfolio-prompts-content-real.md" if it exists in the project root, otherwise usa o conteúdo abaixo.

Cria os seguintes seeders em database/seeders/:

1. database/seeders/UserSeeder.php — cria utilizador admin:
User::firstOrCreate(['email' => 'admin@thgo.me'], [
    'name'     => 'Thiago Rodrigues',
    'password' => bcrypt('password'),
]);

2. database/seeders/SettingSeeder.php — com todos os valores reais definidos anteriormente (site_name, hero_title, about_text completo, socials, etc.)

3. database/seeders/CategorySeeder.php — 5 categorias:
Enterprise UX (#6366F1) / Product Design (#E8FF47) / Design Systems (#10B981) / 0→1 Products (#F59E0B) / Fintech (#3B82F6)

4. database/seeders/ProjectSeeder.php — 5 projectos reais com o HTML COMPLETO de descrição:
- Thr33 (sort_order:1, category: 0→1 Products, year:2024, url:https://99web.pt)
- McKesson (sort_order:2, category: Enterprise UX, year:2025)
- BladeInsight (sort_order:3, category: Design Systems, year:2023)
- MindTools (sort_order:4, category: Product Design, year:2023)
- Progress Systems (sort_order:5, category: Fintech, year:2019)

Para cada projecto, o campo description deve ter o HTML COMPLETO com h2, h3, h4, ul, li, blockquote exactamente como definido no ficheiro portfolio-prompts-content-real.md.

Cada projecto termina com:
try {
    $project->addMediaFromUrl('URL_PEXELS_AQUI')->toMediaCollection('cover');
} catch (\Exception $e) { logger('Media: '.$e->getMessage()); }

URLs das covers:
- Thr33: https://images.pexels.com/photos/3182812/pexels-photo-3182812.jpeg
- McKesson: https://images.pexels.com/photos/3184465/pexels-photo-3184465.jpeg
- BladeInsight: https://images.pexels.com/photos/1108572/pexels-photo-1108572.jpeg
- MindTools: https://images.pexels.com/photos/3184338/pexels-photo-3184338.jpeg
- Progress Systems: https://images.pexels.com/photos/6801648/pexels-photo-6801648.jpeg

5. database/seeders/ServiceSeeder.php — 6 serviços reais (Product Design ◈ / UX Research ◉ / Design Systems ⬡ / UX Audit ◎ / AI-augmented Design ◆ / Technical Product Consulting ◇)

6. database/seeders/TestimonialSeeder.php — 3 testemunhos placeholder

7. database/seeders/DatabaseSeeder.php — chama na ordem correcta com output:
$this->call([UserSeeder::class]);    $this->command->info('✓ Users');
$this->call([SettingSeeder::class]); $this->command->info('✓ Settings');
$this->call([CategorySeeder::class]);$this->command->info('✓ Categories');
$this->call([ProjectSeeder::class]); $this->command->info('✓ Projects');
$this->call([ServiceSeeder::class]); $this->command->info('✓ Services');
$this->call([TestimonialSeeder::class]);$this->command->info('✓ Testimonials');

Depois de criar todos os seeders, corre:
php artisan migrate:fresh --seed

Se houver erros de media (sem internet), continua — o seeder tem try/catch.
No final, verifica:
php artisan tinker
>>> App\Models\Project::count()
>>> App\Models\Setting::get('hero_title')
>>> exit
```

---

## PROMPT 10 — Storage, Verificação Final, npm build

```
Executa os seguintes comandos e corrige qualquer erro que apareça:

php artisan storage:link
php artisan config:clear
php artisan route:clear
php artisan view:clear
npm run build

Depois cria public/images/placeholder.jpg — uma imagem simples de fallback.
Podes usar este comando para criar um placeholder de 1x1 pixel:
php -r "file_put_contents('public/images/placeholder.jpg', base64_decode('/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAABAAEDASIAAhEBAxEB/8QAFAABAAAAAAAAAAAAAAAAAAAACf/EABQQAQAAAAAAAAAAAAAAAAAAAAD/xAAUAQEAAAAAAAAAAAAAAAAAAAAA/8QAFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAwDAQACEQMRAD8AJQAB/9k='));"

Verifica que tudo funciona:
php artisan serve &
sleep 3

# Testa as rotas principais
curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/
curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/work
curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/about
curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/contact
curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/admin

# Todos devem retornar 200 (admin pode retornar 302 redirect para login)
# Se algum retornar 500, mostra o log:
tail -50 storage/logs/laravel.log

Cria um README.md na raiz com:
# thgo-portfolio

Stack: Laravel 11 · Filament 3 · Spatie MediaLibrary · Tailwind · Alpine.js · GSAP · Lenis

## Setup local
1. cp .env.example .env && php artisan key:generate
2. Edita .env com as tuas credenciais de MySQL
3. php artisan migrate:fresh --seed
4. php artisan storage:link
5. npm install && npm run dev
6. php artisan serve

Admin: http://localhost:8000/admin
Login: admin@thgo.me / password

## Deploy (Forge + Hetzner)
Ver .claude/references/deploy-forge.md
```

---

## Checklist Final

```bash
# Tudo deve funcionar antes de fazer deploy:
✓ http://localhost:8000           → homepage com 5 case-rows
✓ http://localhost:8000/work      → lista de todos os cases
✓ http://localhost:8000/work/thr33 → case study Thr33
✓ http://localhost:8000/about     → about com timeline
✓ http://localhost:8000/contact   → formulário
✓ http://localhost:8000/admin     → Filament login
✓ npm run build                   → sem erros
```
