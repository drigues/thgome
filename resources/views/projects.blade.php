<x-app-layout :metaTitle="'Work'">

<section class="pt-24 md:pt-40 pb-20">
    <div class="container mx-auto px-6">

        {{-- Header --}}
        <h1 class="font-heading font-extrabold leading-none mb-16 text-[clamp(3rem,10vw,120px)]" data-split>Work</h1>

        {{-- Filters + Grid --}}
        <div x-data="{ active: 'all' }">

            {{-- Category filters --}}
            <div class="flex flex-wrap gap-3 mb-12" data-animate>
                <button @click="active = 'all'"
                        :class="active === 'all'
                            ? 'bg-[var(--color-accent)] text-[var(--color-bg)]'
                            : 'border border-[var(--color-border)] text-[var(--color-text-muted)] hover:border-[var(--color-accent)] hover:text-[var(--color-accent)]'"
                        class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-200">
                    All
                </button>
                @foreach($categories as $category)
                <button @click="active = '{{ $category->slug }}'"
                        :class="active === '{{ $category->slug }}'
                            ? 'bg-[var(--color-accent)] text-[var(--color-bg)]'
                            : 'border border-[var(--color-border)] text-[var(--color-text-muted)] hover:border-[var(--color-accent)] hover:text-[var(--color-accent)]'"
                        class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-200">
                    {{ $category->name }}
                </button>
                @endforeach
            </div>

            {{-- Project count --}}
            <p class="text-[var(--color-text-muted)] text-xs font-mono uppercase tracking-widest mb-8" data-animate>
                {{ $projects->count() }} projects
            </p>

            {{-- Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                <a href="{{ route('project', $project) }}"
                   class="group block"
                   x-show="active === 'all' || active === '{{ $project->category?->slug }}'"
                   x-transition:enter="transition duration-300 ease-out"
                   x-transition:enter-start="opacity-0 scale-95"
                   x-transition:enter-end="opacity-100 scale-100"
                   x-transition:leave="transition duration-200 ease-in"
                   x-transition:leave-start="opacity-100 scale-100"
                   x-transition:leave-end="opacity-0 scale-95"
                   data-animate>
                    <div class="relative aspect-[4/3] overflow-hidden rounded-2xl bg-[var(--color-bg-card)] mb-4">
                        <img src="{{ $project->cover_url }}"
                             alt="{{ $project->title }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                             loading="lazy">
                        <div class="absolute inset-0 bg-[var(--color-bg)]/0 group-hover:bg-[var(--color-bg)]/50 transition-all duration-300 flex items-center justify-center">
                            <span class="text-[var(--color-text)] font-heading font-semibold text-sm opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0 border border-[var(--color-border)] px-5 py-2.5 rounded-full bg-[var(--color-bg)]/80 backdrop-blur-sm">
                                View case →
                            </span>
                        </div>
                        @if($project->category)
                        <div class="absolute top-4 left-4">
                            <span class="text-xs font-medium px-3 py-1 rounded-full bg-[var(--color-bg)]/80 backdrop-blur-sm text-[var(--color-text)] border border-[var(--color-border)]">
                                {{ $project->category->name }}
                            </span>
                        </div>
                        @endif
                        @if($project->year)
                        <div class="absolute top-4 right-4">
                            <span class="text-xs font-mono px-3 py-1 rounded-full bg-[var(--color-bg)]/80 backdrop-blur-sm text-[var(--color-text-muted)] border border-[var(--color-border)]">
                                {{ $project->year }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="font-heading font-bold text-xl mb-1 group-hover:text-[var(--color-accent)] transition-colors duration-300">
                            {{ $project->title }}
                        </h2>
                        <p class="text-[var(--color-text-muted)] text-sm line-clamp-2">
                            {{ $project->excerpt }}
                        </p>
                        @if($project->client)
                        <p class="text-[var(--color-text-muted)] text-xs mt-2 font-mono">
                            {{ $project->client }}
                        </p>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>

        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.Splitting) {
        Splitting({ target: '[data-split]', by: 'chars' });
        gsap.from('[data-split] .char', {
            y: '110%', opacity: 0, duration: 0.9,
            stagger: 0.02, ease: 'power4.out', delay: 0.1
        });
    }
    gsap.utils.toArray('[data-animate]').forEach(el => {
        gsap.fromTo(el,
            { y: 40, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.7, ease: 'power3.out',
              scrollTrigger: { trigger: el, start: 'top 88%' } }
        );
    });
});
</script>
@endpush

</x-app-layout>
