<x-app-layout>

{{-- HERO --}}
<section class="relative min-h-screen flex flex-col justify-end pb-24 overflow-hidden">
    <div class="container mx-auto px-6 relative z-10">
        <!--p class="font-mono tracking-[0.25em] uppercase mb-8 opacity-0"
           style="color: var(--color-neon); background: #111; display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 0.7rem;"
           data-hero-tag>
        </p -->
        <h1 class="font-heading font-extrabold leading-none mb-8 mt-0 text-[clamp(2.8rem,8vw,140px)]" data-split>
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

{{-- INTRO VIDEO --}}
@php
    $introVideoUrl = \App\Models\SiteMedia::getUrl('intro_video');
    $introVideoThumb = \App\Models\SiteMedia::getUrl('intro_video', 'thumb');
@endphp
@if($introVideoUrl)
<section class="relative overflow-hidden">
    <div class="bg-[var(--color-bg-card)] border-y border-[var(--color-border)]">
        <div class="container mx-auto px-6 py-16 lg:py-24">

            {{-- Header --}}
            <div class="mb-12" data-animate>
                <p class="text-xs font-mono uppercase tracking-[0.25em] mb-4 text-[var(--color-accent)]">
                    Hi, I'm Thiago
                </p>
                <h2 class="font-heading font-bold text-4xl md:text-5xl text-[var(--color-text)]">
                    Nice to meet you.
                </h2>
            </div>

            {{-- Player --}}
            <div class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-2xl max-w-5xl mx-auto"
                 x-data="{ playing: false }" data-animate>

                {{-- Thumbnail overlay shown before play --}}
                <div x-show="!playing"
                     class="absolute inset-0 flex items-center justify-center cursor-pointer group z-10"
                     @click="playing = true">

                    {{-- Background: thumbnail or dark fallback --}}
                    @if($introVideoThumb)
                    <img src="{{ $introVideoThumb }}"
                         alt="Video thumbnail"
                         class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/30"></div>
                    @else
                    <div class="absolute inset-0 bg-[var(--color-bg-alt)]"></div>
                    @endif

                    {{-- Play button --}}
                    <div class="relative z-10 flex flex-col items-center gap-4">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-110 shadow-2xl"
                             style="background: var(--color-neon)">
                            <svg class="w-7 h-7 ml-1" viewBox="0 0 24 24" fill="#111">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Video --}}
                <template x-if="playing">
                    <video
                        src="{{ $introVideoUrl }}"
                        class="absolute inset-0 w-full h-full object-cover"
                        controls
                        autoplay
                        playsinline
                        @if($introVideoThumb) poster="{{ $introVideoThumb }}" @endif>
                    </video>
                </template>
            </div>

        </div>
    </div>
</section>
@endif

{{-- SELECTED WORK --}}
<section class="py-32 relative">
    <div class="container mx-auto px-6">
        <div class="relative mb-20">
            <span class="absolute -top-16 right-0 font-heading font-bold text-[clamp(80px,15vw,200px)] text-[var(--color-text)] opacity-[0.06] select-none leading-none">01</span>
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
                <span class="font-mono w-8 shrink-0 hidden sm:block" style="color: var(--color-neon); background: #111; padding: 2px 6px; border-radius: 4px; font-size: 0.65rem;">
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
                {{-- <!-- div class="case-hover-image pointer-events-none absolute right-56 top-1/2 -translate-y-1/2
                            w-72 h-44 rounded-xl overflow-hidden opacity-0 group-hover:opacity-100
                            transition-all duration-500 scale-95 group-hover:scale-100 z-10 hidden xl:block">
                    <img src="{{ $project->cover_url }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                </div --> --}}
            </a>
            @endforeach
        </div>

        <div class="mt-8 md:hidden">
            <a href="{{ route('projects') }}" class="text-[var(--color-accent)] text-sm font-medium">All work →</a>
        </div>
    </div>
</section>

{{-- MARQUEE --}}
<div class="border-y border-[var(--color-border)] py-4 overflow-hidden">
    <div class="flex whitespace-nowrap">
        <div class="marquee-inner flex items-center gap-12 pr-12 shrink-0">
            @php
            $items = $categories->count()
                ? $categories->pluck('name')->toArray()
                : ['Product Design','UX Research','Design Systems','Enterprise UX','0→1 Products','Fintech','AI-augmented Workflows','Interaction Design','Product Design','UX Research','Design Systems','Enterprise UX','0→1 Products','Fintech','AI-augmented Workflows','Interaction Design'];
            @endphp
            @foreach(array_merge($items,$items,$items,$items) as $item)
            <span class="text-[var(--color-text-muted)] text-xs font-medium tracking-widest uppercase whitespace-nowrap">{{ $item }}</span>
            <span style="color: var(--color-neon); padding: 1px 3px; border-radius: 2px; font-size: 0.6rem;">✦</span>
            @endforeach
        </div>
        <div class="marquee-inner flex items-center gap-12 pr-12 shrink-0" aria-hidden="true">
            @foreach(array_merge($items,$items,$items,$items) as $item)
            <span class="text-[var(--color-text-muted)] text-xs font-medium tracking-widest uppercase whitespace-nowrap">{{ $item }}</span>
            <span style="color: var(--color-neon); padding: 1px 3px; border-radius: 2px; font-size: 0.6rem;">✦</span>
            @endforeach
        </div>
    </div>
</div>

{{-- ABOUT SNIPPET --}}
<section class="py-32">
    <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-5 gap-16 items-start">
            <div class="lg:col-span-3">
                <div class="relative">
                    <span class="absolute -top-12 -left-4 font-heading font-bold text-[clamp(60px,12vw,160px)] text-[var(--color-text)] opacity-[0.06] select-none leading-none">02</span>
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
            <span class="absolute -top-16 right-0 font-heading font-bold text-[clamp(80px,15vw,200px)] text-[var(--color-text)] opacity-[0.06] select-none leading-none">03</span>
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
    const marquees = document.querySelectorAll('.marquee-inner');
    if (marquees.length >= 2) {
        const totalWidth = marquees[0].offsetWidth;
        gsap.set(marquees[1], { x: totalWidth });
        gsap.to(marquees, {
            x: '-=' + totalWidth,
            ease: 'none',
            duration: 90,
            repeat: -1,
            modifiers: {
                x: gsap.utils.unitize(x => parseFloat(x) % totalWidth)
            }
        });
    }
});
</script>
@endpush
</x-app-layout>
