<x-app-layout :metaTitle="'Work'">

<section class="pt-40 pb-12">
    <div class="container mx-auto px-6">
        <p class="text-[var(--color-accent)] font-mono text-xs tracking-[0.25em] uppercase mb-8" data-animate>Carrer</p>
        <h1 class="font-heading font-extrabold leading-none mb-16 text-[clamp(80px,14vw,200px)]" data-split>Work</h1>

        <div x-data="{ active: 'all' }" class="space-y-12">
            {{-- Filter pills --}}
            <div class="flex flex-wrap gap-3" data-animate>
                <button @click="active = 'all'"
                        :class="active === 'all' ? 'bg-[var(--color-accent)] text-[var(--color-bg)]' : 'border border-[var(--color-border)] text-[var(--color-text-muted)]'"
                        class="px-5 py-2 rounded-full text-sm font-medium transition-colors">
                    All
                </button>
                @foreach($categories as $category)
                <button @click="active = '{{ $category->slug }}'"
                        :class="active === '{{ $category->slug }}' ? 'bg-[var(--color-accent)] text-[var(--color-bg)]' : 'border border-[var(--color-border)] text-[var(--color-text-muted)]'"
                        class="px-5 py-2 rounded-full text-sm font-medium transition-colors">
                    {{ $category->name }}
                </button>
                @endforeach
            </div>

            {{-- Desktop: editorial list --}}
            <div class="hidden md:block divide-y divide-[var(--color-border)]">
                @foreach($projects as $i => $project)
                <a href="{{ route('project', $project) }}"
                   x-show="active === 'all' || active === '{{ $project->category?->slug }}'"
                   x-transition:enter="transition duration-300"
                   x-transition:enter-start="opacity-0"
                   class="case-row group relative flex items-center gap-6 py-8 overflow-hidden">
                    <span class="text-[var(--color-text-muted)] font-mono text-sm w-8 shrink-0">
                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    <h2 class="font-heading font-bold text-3xl lg:text-5xl xl:text-6xl flex-1 leading-none
                                group-hover:text-[var(--color-accent)] transition-colors duration-300">
                        {{ $project->title }}
                    </h2>
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

            {{-- Mobile: grid cards --}}
            <div class="md:hidden grid grid-cols-1 gap-8">
                @foreach($projects as $project)
                <article
                    x-show="active === 'all' || active === '{{ $project->category?->slug }}'"
                    x-transition:enter="transition duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    class="group">
                    <a href="{{ route('project', $project) }}">
                        <div class="relative aspect-[4/3] overflow-hidden rounded-lg bg-[var(--color-bg-card)] mb-3">
                            <img src="{{ $project->cover_url }}" alt="{{ $project->title }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                 loading="lazy">
                        </div>
                        <h2 class="font-heading font-semibold text-sm group-hover:text-[var(--color-accent)] transition-colors">
                            {{ $project->title }}
                        </h2>
                        @if($project->year)
                        <p class="text-[var(--color-text-muted)] text-xs mt-1">{{ $project->year }}</p>
                        @endif
                    </a>
                </article>
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
            stagger: 0.02, ease: 'power4.out', delay: 0.2
        });
    }
    gsap.utils.toArray('.case-row').forEach((row, i) => {
        gsap.fromTo(row,
            { clipPath: 'inset(0 0 100% 0)', opacity: 0 },
            { clipPath: 'inset(0 0 0% 0)', opacity: 1, duration: 0.7,
              ease: 'power3.out', delay: i * 0.05,
              scrollTrigger: { trigger: row, start: 'top 90%' } }
        );
    });
});
</script>
@endpush
</x-app-layout>
