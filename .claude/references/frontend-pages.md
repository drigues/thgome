# Frontend Pages — Blade + GSAP

## Nav (partials/nav.blade.php)

```html
<header id="site-nav" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        x-data="{ open: false, scrolled: false }"
        x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 60)"
        :class="scrolled ? 'bg-[var(--color-bg)]/95 backdrop-blur-sm border-b border-[var(--color-border)]' : ''">
    <nav class="container mx-auto px-6 py-5 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="font-heading font-bold text-xl tracking-tight">
            {{ Setting::get('site_name', 'Portfolio') }}
        </a>

        <!-- Desktop Menu -->
        <ul class="hidden md:flex items-center gap-8 text-sm font-medium">
            <li><a href="{{ route('projects') }}" class="text-[var(--color-text-muted)] hover:text-[var(--color-text)] transition-colors">Projetos</a></li>
            <li><a href="{{ route('services') }}" class="text-[var(--color-text-muted)] hover:text-[var(--color-text)] transition-colors">Serviços</a></li>
            <li><a href="{{ route('about') }}" class="text-[var(--color-text-muted)] hover:text-[var(--color-text)] transition-colors">Sobre</a></li>
            <li><a href="{{ route('blog') }}" class="text-[var(--color-text-muted)] hover:text-[var(--color-text)] transition-colors">Blog</a></li>
            <li>
                <a href="{{ route('contact') }}"
                   class="bg-[var(--color-accent)] text-[var(--color-bg)] font-semibold px-4 py-2 rounded-full text-sm hover:bg-[var(--color-accent-dark)] transition-colors">
                    Contacto
                </a>
            </li>
        </ul>

        <!-- Mobile Hamburger -->
        <button @click="open = !open" class="md:hidden flex flex-col gap-1.5 p-2" aria-label="Menu">
            <span :class="open ? 'rotate-45 translate-y-2' : ''" class="block w-6 h-0.5 bg-current transition-transform duration-300"></span>
            <span :class="open ? 'opacity-0' : ''" class="block w-6 h-0.5 bg-current transition-opacity duration-300"></span>
            <span :class="open ? '-rotate-45 -translate-y-2' : ''" class="block w-6 h-0.5 bg-current transition-transform duration-300"></span>
        </button>
    </nav>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0 -translate-y-4"
         class="md:hidden absolute top-full left-0 right-0 bg-[var(--color-bg)] border-b border-[var(--color-border)] px-6 py-8">
        <ul class="flex flex-col gap-6 text-lg font-medium">
            <li><a href="{{ route('projects') }}" @click="open=false">Projetos</a></li>
            <li><a href="{{ route('services') }}" @click="open=false">Serviços</a></li>
            <li><a href="{{ route('about') }}" @click="open=false">Sobre</a></li>
            <li><a href="{{ route('blog') }}" @click="open=false">Blog</a></li>
            <li><a href="{{ route('contact') }}" @click="open=false"
                   class="inline-block bg-[var(--color-accent)] text-[var(--color-bg)] font-semibold px-6 py-3 rounded-full">
                Contacto
            </a></li>
        </ul>
    </div>
</header>
```

---

## Homepage (views/home.blade.php)

```html
<x-app-layout>
    {{-- HERO --}}
    <section class="relative min-h-screen flex items-center pt-20 overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="max-w-5xl">
                <p class="text-[var(--color-accent)] font-mono text-sm tracking-widest uppercase mb-6 opacity-0"
                   data-hero-tag>
                    {{ Setting::get('site_tagline', 'Creative Portfolio') }}
                </p>
                <h1 class="font-heading font-extrabold leading-none mb-8" data-split>
                    {{ Setting::get('hero_title', 'Design &\nDevelopment') }}
                </h1>
                <p class="text-[var(--color-text-muted)] text-xl max-w-lg mb-12 opacity-0" data-hero-sub>
                    {{ Setting::get('hero_subtitle', '') }}
                </p>
                <div class="flex flex-wrap gap-4 opacity-0" data-hero-cta>
                    <a href="{{ route('projects') }}"
                       class="bg-[var(--color-accent)] text-[var(--color-bg)] font-semibold px-8 py-4 rounded-full hover:bg-[var(--color-accent-dark)] transition-colors">
                        {{ Setting::get('hero_cta_text', 'Ver Projetos') }}
                    </a>
                    <a href="{{ route('contact') }}"
                       class="border border-[var(--color-border)] text-[var(--color-text)] font-semibold px-8 py-4 rounded-full hover:border-[var(--color-text)] transition-colors">
                        Contacto
                    </a>
                </div>
            </div>
        </div>
        <!-- Decoração fundo -->
        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[45vw] h-[45vw] rounded-full bg-[var(--color-accent)]/5 blur-3xl pointer-events-none"></div>
    </section>

    {{-- PROJETOS EM DESTAQUE --}}
    <section class="py-32">
        <div class="container mx-auto px-6">
            <div class="flex items-end justify-between mb-16" data-animate>
                <h2 class="font-heading font-bold text-4xl md:text-5xl">Trabalhos<br>Selecionados</h2>
                <a href="{{ route('projects') }}" class="text-[var(--color-accent)] hover:underline text-sm font-medium">
                    Ver todos →
                </a>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                @foreach($featuredProjects as $project)
                <article class="group cursor-pointer" data-animate>
                    <a href="{{ route('project', $project) }}">
                        <div class="relative aspect-[4/3] overflow-hidden rounded-lg bg-[var(--color-bg-card)] mb-5">
                            <img src="{{ $project->cover_url }}"
                                 alt="{{ $project->title }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                 loading="lazy">
                            <div class="absolute inset-0 bg-[var(--color-bg)]/0 group-hover:bg-[var(--color-bg)]/40 transition-colors duration-300 flex items-center justify-center">
                                <span class="text-[var(--color-accent)] font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0 transition-transform">
                                    Ver Projeto →
                                </span>
                            </div>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="font-heading font-semibold text-xl group-hover:text-[var(--color-accent)] transition-colors">
                                    {{ $project->title }}
                                </h3>
                                <p class="text-[var(--color-text-muted)] text-sm mt-1">{{ $project->excerpt }}</p>
                            </div>
                            @if($project->category)
                            <span class="text-xs border border-[var(--color-border)] px-3 py-1 rounded-full whitespace-nowrap text-[var(--color-text-muted)] shrink-0">
                                {{ $project->category->name }}
                            </span>
                            @endif
                        </div>
                    </a>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- MARQUEE --}}
    <div class="border-y border-[var(--color-border)] py-5 overflow-hidden">
        <div class="marquee-track flex whitespace-nowrap">
            <span class="marquee-inner flex gap-12 pr-12 text-[var(--color-text-muted)] text-sm font-medium tracking-widest uppercase">
                @foreach($categories as $cat)
                <span>{{ $cat->name }}</span>
                <span class="text-[var(--color-accent)]">✦</span>
                @endforeach
                @foreach($categories as $cat)
                <span>{{ $cat->name }}</span>
                <span class="text-[var(--color-accent)]">✦</span>
                @endforeach
            </span>
        </div>
    </div>

    {{-- SERVIÇOS --}}
    <section class="py-32">
        <div class="container mx-auto px-6">
            <h2 class="font-heading font-bold text-4xl md:text-5xl mb-16" data-animate>
                O Que Faço
            </h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                <div class="border border-[var(--color-border)] rounded-xl p-8 hover:border-[var(--color-accent)]/50 transition-colors group" data-animate>
                    @if($service->icon)
                    <div class="text-[var(--color-accent)] mb-5 text-3xl">{!! $service->icon !!}</div>
                    @endif
                    <h3 class="font-heading font-semibold text-xl mb-3 group-hover:text-[var(--color-accent)] transition-colors">
                        {{ $service->title }}
                    </h3>
                    <p class="text-[var(--color-text-muted)] text-sm leading-relaxed">{{ $service->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TESTEMUNHOS --}}
    @if($testimonials->count())
    <section class="py-32 bg-[var(--color-bg-alt)]">
        <div class="container mx-auto px-6">
            <h2 class="font-heading font-bold text-4xl md:text-5xl mb-16" data-animate>O Que Dizem</h2>
            <div x-data="{ active: 0 }" class="relative">
                @foreach($testimonials as $i => $t)
                <div x-show="active === {{ $i }}" x-transition:enter="transition duration-500"
                     x-transition:enter-start="opacity-0 translate-y-4" class="max-w-2xl">
                    <p class="text-2xl font-heading font-medium leading-relaxed mb-8">
                        "{{ $t->content }}"
                    </p>
                    <div class="flex items-center gap-4">
                        @if($t->avatar)
                        <img src="{{ asset('storage/' . $t->avatar) }}" alt="{{ $t->name }}"
                             class="w-12 h-12 rounded-full object-cover">
                        @endif
                        <div>
                            <p class="font-semibold">{{ $t->name }}</p>
                            @if($t->company)<p class="text-[var(--color-text-muted)] text-sm">{{ $t->role ? $t->role . ' · ' : '' }}{{ $t->company }}</p>@endif
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- Dots navigation -->
                <div class="flex gap-2 mt-10">
                    @foreach($testimonials as $i => $t)
                    <button @click="active = {{ $i }}"
                            :class="active === {{ $i }} ? 'bg-[var(--color-accent)] w-8' : 'bg-[var(--color-border)] w-2'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- CTA --}}
    <section class="py-40">
        <div class="container mx-auto px-6 text-center" data-animate>
            <h2 class="font-heading font-extrabold text-5xl md:text-7xl mb-8">
                Vamos trabalhar<br>
                <span class="text-[var(--color-accent)]">juntos?</span>
            </h2>
            <a href="{{ route('contact') }}"
               class="inline-block bg-[var(--color-accent)] text-[var(--color-bg)] font-semibold px-10 py-5 rounded-full text-lg hover:bg-[var(--color-accent-dark)] transition-colors">
                Iniciar Projeto
            </a>
        </div>
    </section>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Hero animations
        const results = Splitting({ target: 'h1[data-split]', by: 'chars' });
        const tl = gsap.timeline();
        tl.from('h1[data-split] .char', {
            y: '110%', opacity: 0, duration: 0.9, stagger: 0.02, ease: 'power4.out'
        })
        .from('[data-hero-tag]', { opacity: 0, y: 20, duration: 0.6 }, '-=0.6')
        .from('[data-hero-sub]', { opacity: 0, y: 20, duration: 0.6 }, '-=0.4')
        .from('[data-hero-cta]', { opacity: 0, y: 20, duration: 0.6 }, '-=0.3');

        // Scroll animations
        gsap.utils.toArray('[data-animate]').forEach(el => {
            gsap.fromTo(el,
                { y: 80, opacity: 0 },
                { y: 0, opacity: 1, duration: 1, ease: 'power3.out',
                  scrollTrigger: { trigger: el, start: 'top 88%' } }
            );
        });

        // Marquee
        const marquee = document.querySelector('.marquee-inner');
        if (marquee) {
            gsap.to(marquee, {
                xPercent: -50, ease: 'none', duration: 25, repeat: -1,
                modifiers: { xPercent: gsap.utils.wrap(-50, 0) }
            });
        }
    });
    </script>
    @endpush
</x-app-layout>
```

---

## Projetos — Grid com Filtros (views/projects.blade.php)

```html
<x-app-layout :metaTitle="'Projetos'">
    <section class="pt-40 pb-20">
        <div class="container mx-auto px-6">
            <h1 class="font-heading font-extrabold text-5xl md:text-7xl mb-16" data-animate>Projetos</h1>

            <!-- Filtros de Categoria -->
            <div x-data="{ active: 'all' }" class="space-y-16">
                <div class="flex flex-wrap gap-3" data-animate>
                    <button @click="active = 'all'"
                            :class="active === 'all' ? 'bg-[var(--color-accent)] text-[var(--color-bg)]' : 'border border-[var(--color-border)] text-[var(--color-text-muted)]'"
                            class="px-5 py-2 rounded-full text-sm font-medium transition-colors">
                        Todos
                    </button>
                    @foreach($categories as $category)
                    <button @click="active = '{{ $category->slug }}'"
                            :class="active === '{{ $category->slug }}' ? 'bg-[var(--color-accent)] text-[var(--color-bg)]' : 'border border-[var(--color-border)] text-[var(--color-text-muted)]'"
                            class="px-5 py-2 rounded-full text-sm font-medium transition-colors">
                        {{ $category->name }}
                    </button>
                    @endforeach
                </div>

                <!-- Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($projects as $project)
                    <article
                        x-show="active === 'all' || active === '{{ $project->category?->slug }}'"
                        x-transition:enter="transition duration-400"
                        x-transition:enter-start="opacity-0 scale-95"
                        class="group"
                        data-animate>
                        <a href="{{ route('project', $project) }}">
                            <div class="relative aspect-[4/3] overflow-hidden rounded-lg bg-[var(--color-bg-card)] mb-4">
                                <img src="{{ $project->cover_url }}" alt="{{ $project->title }}"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                     loading="lazy">
                            </div>
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h2 class="font-heading font-semibold text-lg group-hover:text-[var(--color-accent)] transition-colors">
                                        {{ $project->title }}
                                    </h2>
                                    @if($project->client)
                                    <p class="text-[var(--color-text-muted)] text-sm">{{ $project->client }}</p>
                                    @endif
                                </div>
                                @if($project->year)
                                <span class="text-[var(--color-text-muted)] text-sm shrink-0">{{ $project->year }}</span>
                                @endif
                            </div>
                        </a>
                    </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
```

---

## Projeto Singular (views/project.blade.php)

```html
<x-app-layout :metaTitle="$project->meta_title ?? $project->title" :metaDescription="$project->meta_description ?? $project->excerpt">
    <!-- Hero do Projeto -->
    <section class="pt-40 pb-20">
        <div class="container mx-auto px-6">
            <div class="max-w-3xl">
                @if($project->category)
                <span class="text-[var(--color-accent)] font-mono text-xs tracking-widest uppercase" data-animate>
                    {{ $project->category->name }}
                </span>
                @endif
                <h1 class="font-heading font-extrabold text-5xl md:text-7xl mt-4 mb-6 leading-none" data-animate>
                    {{ $project->title }}
                </h1>
                @if($project->excerpt)
                <p class="text-[var(--color-text-muted)] text-xl" data-animate>{{ $project->excerpt }}</p>
                @endif
            </div>
            <!-- Meta info -->
            <div class="flex flex-wrap gap-10 mt-12 pt-12 border-t border-[var(--color-border)]" data-animate>
                @if($project->client)
                <div>
                    <p class="text-[var(--color-text-muted)] text-xs uppercase tracking-widest mb-1">Cliente</p>
                    <p class="font-medium">{{ $project->client }}</p>
                </div>
                @endif
                @if($project->year)
                <div>
                    <p class="text-[var(--color-text-muted)] text-xs uppercase tracking-widest mb-1">Ano</p>
                    <p class="font-medium">{{ $project->year }}</p>
                </div>
                @endif
                @if($project->url)
                <div>
                    <p class="text-[var(--color-text-muted)] text-xs uppercase tracking-widest mb-1">Link</p>
                    <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer"
                       class="font-medium text-[var(--color-accent)] hover:underline">
                        Ver Projeto →
                    </a>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Capa principal -->
    @if($project->getFirstMediaUrl('cover'))
    <div class="container mx-auto px-6 mb-16" data-animate>
        <img src="{{ $project->getFirstMediaUrl('cover') }}" alt="{{ $project->title }}"
             class="w-full rounded-xl aspect-video object-cover">
    </div>
    @endif

    <!-- Descrição -->
    @if($project->description)
    <section class="container mx-auto px-6 max-w-3xl mb-20" data-animate>
        <div class="prose prose-invert prose-lg max-w-none">
            {!! $project->description !!}
        </div>
    </section>
    @endif

    <!-- Galeria de Fotos -->
    @php $gallery = $project->getMedia('gallery'); @endphp
    @if($gallery->count())
    <section class="container mx-auto px-6 mb-20">
        <h2 class="font-heading font-semibold text-2xl mb-8" data-animate>Galeria</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4" x-data="lightbox()">
            @foreach($gallery as $media)
            <div class="aspect-square overflow-hidden rounded-lg cursor-pointer" data-animate
                 @click="open('{{ $media->getUrl() }}')">
                <img src="{{ $media->getUrl() }}" alt="{{ $project->title }}"
                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                     loading="lazy">
            </div>
            @endforeach
            <!-- Lightbox -->
            <div x-show="isOpen" x-transition class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4"
                 @click.self="isOpen = false" @keydown.escape.window="isOpen = false">
                <button @click="isOpen = false" class="absolute top-6 right-6 text-white/70 hover:text-white text-3xl">✕</button>
                <img :src="currentImage" class="max-h-[90vh] max-w-[90vw] object-contain rounded-lg">
            </div>
        </div>
    </section>
    @endif

    <!-- Vídeos Embeds -->
    @if($project->video_embeds)
    <section class="container mx-auto px-6 mb-20">
        <h2 class="font-heading font-semibold text-2xl mb-8" data-animate>Vídeos</h2>
        <div class="grid md:grid-cols-2 gap-8">
            @foreach($project->video_embeds as $embed)
            <div class="aspect-video rounded-xl overflow-hidden" data-animate>
                @if($embed['platform'] === 'youtube')
                <iframe src="https://www.youtube.com/embed/{{ $embed['embed_id'] }}"
                        title="{{ $embed['title'] ?? $project->title }}"
                        class="w-full h-full" allowfullscreen></iframe>
                @elseif($embed['platform'] === 'vimeo')
                <iframe src="https://player.vimeo.com/video/{{ $embed['embed_id'] }}"
                        title="{{ $embed['title'] ?? $project->title }}"
                        class="w-full h-full" allowfullscreen></iframe>
                @endif
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Vídeos Ficheiro -->
    @php $videos = $project->getMedia('videos'); @endphp
    @if($videos->count())
    <section class="container mx-auto px-6 mb-20">
        @foreach($videos as $video)
        <div class="aspect-video rounded-xl overflow-hidden mb-6" data-animate>
            <video src="{{ $video->getUrl() }}" controls class="w-full h-full rounded-xl">
                O teu browser não suporta vídeo HTML5.
            </video>
        </div>
        @endforeach
    </section>
    @endif

    <!-- Navegação anterior/próximo -->
    <div class="container mx-auto px-6 py-20 border-t border-[var(--color-border)]">
        <div class="flex justify-between">
            @if($previous)
            <a href="{{ route('project', $previous) }}" class="group">
                <p class="text-[var(--color-text-muted)] text-xs uppercase tracking-widest mb-2">← Anterior</p>
                <p class="font-heading font-semibold text-lg group-hover:text-[var(--color-accent)] transition-colors">
                    {{ $previous->title }}
                </p>
            </a>
            @else
            <div></div>
            @endif
            @if($next)
            <a href="{{ route('project', $next) }}" class="group text-right">
                <p class="text-[var(--color-text-muted)] text-xs uppercase tracking-widest mb-2">Próximo →</p>
                <p class="font-heading font-semibold text-lg group-hover:text-[var(--color-accent)] transition-colors">
                    {{ $next->title }}
                </p>
            </a>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
    function lightbox() {
        return {
            isOpen: false,
            currentImage: '',
            open(url) { this.currentImage = url; this.isOpen = true; }
        };
    }
    document.addEventListener('DOMContentLoaded', () => {
        gsap.utils.toArray('[data-animate]').forEach(el => {
            gsap.fromTo(el,
                { y: 60, opacity: 0 },
                { y: 0, opacity: 1, duration: 0.9, ease: 'power3.out',
                  scrollTrigger: { trigger: el, start: 'top 88%' } }
            );
        });
    });
    </script>
    @endpush
</x-app-layout>
```

---

## Contacto (views/contact.blade.php)

```html
<x-app-layout :metaTitle="'Contacto'">
    <section class="pt-40 pb-32">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-20">
                <!-- Info -->
                <div>
                    <h1 class="font-heading font-extrabold text-5xl md:text-6xl mb-8" data-animate>
                        Vamos conversar
                    </h1>
                    <p class="text-[var(--color-text-muted)] text-lg mb-12" data-animate>
                        Tem um projeto em mente? Entre em contacto e vemos como posso ajudar.
                    </p>
                    <div class="space-y-4" data-animate>
                        @if(Setting::get('contact_email'))
                        <a href="mailto:{{ Setting::get('contact_email') }}"
                           class="flex items-center gap-3 text-[var(--color-text-muted)] hover:text-[var(--color-accent)] transition-colors">
                            <span class="text-[var(--color-accent)]">✉</span>
                            {{ Setting::get('contact_email') }}
                        </a>
                        @endif
                        @if(Setting::get('contact_phone'))
                        <a href="tel:{{ Setting::get('contact_phone') }}"
                           class="flex items-center gap-3 text-[var(--color-text-muted)] hover:text-[var(--color-accent)] transition-colors">
                            <span class="text-[var(--color-accent)]">☎</span>
                            {{ Setting::get('contact_phone') }}
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Form -->
                <div x-data="contactForm()" data-animate>
                    <form @submit.prevent="submit" class="space-y-6" novalidate>
                        <!-- Honeypot -->
                        <input type="text" name="website" x-model="form.website" class="hidden" tabindex="-1" autocomplete="off">

                        <div>
                            <input type="text" x-model="form.name" placeholder="Nome *"
                                   class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border)] rounded-lg px-5 py-4 text-[var(--color-text)] placeholder-[var(--color-text-muted)] focus:outline-none focus:border-[var(--color-accent)] transition-colors">
                        </div>
                        <div>
                            <input type="email" x-model="form.email" placeholder="Email *"
                                   class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border)] rounded-lg px-5 py-4 text-[var(--color-text)] placeholder-[var(--color-text-muted)] focus:outline-none focus:border-[var(--color-accent)] transition-colors">
                        </div>
                        <div>
                            <input type="text" x-model="form.subject" placeholder="Assunto"
                                   class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border)] rounded-lg px-5 py-4 text-[var(--color-text)] placeholder-[var(--color-text-muted)] focus:outline-none focus:border-[var(--color-accent)] transition-colors">
                        </div>
                        <div>
                            <textarea x-model="form.message" placeholder="Mensagem *" rows="5"
                                      class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border)] rounded-lg px-5 py-4 text-[var(--color-text)] placeholder-[var(--color-text-muted)] focus:outline-none focus:border-[var(--color-accent)] transition-colors resize-none"></textarea>
                        </div>

                        <button type="submit" :disabled="loading"
                                class="w-full bg-[var(--color-accent)] text-[var(--color-bg)] font-semibold py-4 rounded-lg hover:bg-[var(--color-accent-dark)] transition-colors disabled:opacity-50">
                            <span x-show="!loading">Enviar Mensagem</span>
                            <span x-show="loading">A enviar...</span>
                        </button>

                        <div x-show="success" x-transition class="p-4 bg-green-900/30 border border-green-700/50 rounded-lg text-green-400 text-sm">
                            ✓ Mensagem enviada com sucesso! Responderei brevemente.
                        </div>
                        <div x-show="error" x-transition class="p-4 bg-red-900/30 border border-red-700/50 rounded-lg text-red-400 text-sm">
                            ✕ Erro ao enviar. Por favor tente novamente.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
    function contactForm() {
        return {
            form: { name: '', email: '', subject: '', message: '', website: '' },
            loading: false, success: false, error: false,
            async submit() {
                this.loading = true; this.success = false; this.error = false;
                try {
                    const res = await fetch('{{ route("contact.submit") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify(this.form),
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.success = true;
                        this.form = { name: '', email: '', subject: '', message: '', website: '' };
                    } else { this.error = true; }
                } catch { this.error = true; }
                finally { this.loading = false; }
            }
        };
    }
    </script>
    @endpush
</x-app-layout>
```
