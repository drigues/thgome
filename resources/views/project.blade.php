<x-app-layout :metaTitle="$project->meta_title ?? $project->title" :metaDescription="$project->meta_description ?? $project->excerpt">

{{-- HERO --}}
<section class="relative min-h-[80vh] flex flex-col justify-end pb-20 overflow-hidden">
    @if($project->getFirstMediaUrl('cover'))
    <!-- div class="absolute inset-0">
        <img src="{{ $project->getFirstMediaUrl('cover') }}" alt="{{ $project->title }}"
             class="w-full h-full object-cover" id="project-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[var(--color-bg)]/60 to-[var(--color-bg)]"></div>
    </div -->
    @endif
    <div class="container mx-auto px-6 relative z-10">
        @if($project->category)
        <span class="text-[var(--color-accent)] font-mono text-xs tracking-widest uppercase" data-animate>
            {{ $project->category->name }}
        </span>
        @endif
        <h1 class="font-heading font-extrabold text-5xl md:text-7xl mt-4 mb-6 leading-none" data-split>
            {{ $project->title }}
        </h1>
        @if($project->excerpt)
        <p class="text-[var(--color-text-muted)] text-xl max-w-2xl" data-animate>{{ $project->excerpt }}</p>
        @endif
        <div class="flex flex-wrap gap-10 mt-12 pt-12 border-t border-white/10" data-animate>
            @if($project->client)
            <div>
                <p class="text-[var(--color-text-muted)] text-xs uppercase tracking-widest mb-1">Client</p>
                <p class="font-medium">{{ $project->client }}</p>
            </div>
            @endif
            @if($project->year)
            <div>
                <p class="text-[var(--color-text-muted)] text-xs uppercase tracking-widest mb-1">Year</p>
                <p class="font-medium">{{ $project->year }}</p>
            </div>
            @endif
            @if($project->url)
            <div>
                <p class="text-[var(--color-text-muted)] text-xs uppercase tracking-widest mb-1">Link</p>
                <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer"
                   class="font-medium text-[var(--color-accent)] hover:underline">
                    Visit Project →
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- Cover image full-bleed --}}
@if($project->getFirstMediaUrl('cover'))
<div class="mb-20" data-animate>
    <img src="{{ $project->getFirstMediaUrl('cover') }}" alt="{{ $project->title }}"
         class="w-full aspect-video object-cover" id="project-cover-full">
</div>
@endif

{{-- Description Part 1 --}}
@if($project->description)
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-[1fr_300px] gap-16 items-start max-w-6xl mx-auto">
            <div class="prose-portfolio min-w-0">
                {!! $project->description !!}
            </div>
            <aside class="hidden lg:block mt-8">
                <div class="sticky mt-8 top-32 space-y-3">
                    <p class="text-xs font-mono uppercase tracking-widest text-[var(--color-text-muted)] mb-4">On this page</p>
                    @php
                        preg_match_all('/<h2[^>]*>(.*?)<\/h2>/i', $project->description . ($project->description_two ?? ''), $matches);
                        $headings = $matches[1] ?? [];
                    @endphp
                    @foreach($headings as $heading)
                    <div class="border-l-2 border-[var(--color-border)] pl-4 py-1 hover:border-[var(--color-accent)] transition-colors">
                        <p class="text-xs text-[var(--color-text-muted)] leading-snug">{{ strip_tags($heading) }}</p>
                    </div>
                    @endforeach
                    @if($project->url)
                    <div class="pt-6">
                        <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer"
                           class="flex items-center gap-2 text-sm font-medium text-[var(--color-accent)] hover:underline">
                            Visit project →
                        </a>
                    </div>
                    @endif
                </div>
            </aside>
        </div>
    </div>
</section>
@endif

{{-- Gallery (between the two descriptions) --}}
@php $gallery = $project->getMedia('gallery'); @endphp
@if($gallery->count())
<section class="py-16 bg-[var(--color-bg-alt)]">
    <div class="container mx-auto px-6">
        <p class="text-xs font-mono uppercase tracking-widest text-[var(--color-text-muted)] mb-8">Gallery</p>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 lg:gap-4" x-data="{ isOpen: false, currentImage: '' }">
            @foreach($gallery as $i => $media)
            <div class="{{ $i === 0 ? 'col-span-2 row-span-2' : '' }} overflow-hidden rounded-xl cursor-pointer aspect-square"
                 @click="currentImage = '{{ $media->getUrl() }}'; isOpen = true">
                <img src="{{ $media->getUrl() }}" alt="{{ $project->title }}"
                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-700"
                     loading="lazy">
            </div>
            @endforeach

            {{-- Lightbox --}}
            <div x-show="isOpen" x-transition
                 class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4"
                 @click.self="isOpen = false"
                 @keydown.escape.window="isOpen = false">
                <button @click="isOpen = false"
                        class="absolute top-6 right-6 text-white/70 hover:text-white text-3xl leading-none">✕</button>
                <img :src="currentImage"
                     class="max-h-[90vh] max-w-[90vw] object-contain rounded-xl">
            </div>
        </div>
    </div>
</section>
@endif

{{-- Description Part 2 --}}
@if($project->description_two)
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto">
            <div class="prose-portfolio min-w-0 lg:max-w-[calc(100%-316px)]">
                {!! $project->description_two !!}
            </div>
        </div>
    </div>
</section>
@endif

{{-- Videos --}}
@php $videos = $project->getMedia('videos'); @endphp
@if($project->video_embeds || $videos->count())
<section class="py-16 container mx-auto px-6">
    <p class="text-xs font-mono uppercase tracking-widest text-[var(--color-text-muted)] mb-8">Videos</p>
    <div class="grid md:grid-cols-2 gap-6 max-w-6xl mx-auto">
        @if($project->video_embeds)
            @foreach($project->video_embeds as $embed)
            <div class="aspect-video rounded-xl overflow-hidden">
                @if($embed['platform'] === 'youtube')
                <iframe src="https://www.youtube.com/embed/{{ $embed['embed_id'] }}"
                        title="{{ $embed['title'] ?? $project->title }}"
                        class="w-full h-full" allowfullscreen loading="lazy"></iframe>
                @elseif($embed['platform'] === 'vimeo')
                <iframe src="https://player.vimeo.com/video/{{ $embed['embed_id'] }}"
                        title="{{ $embed['title'] ?? $project->title }}"
                        class="w-full h-full" allowfullscreen loading="lazy"></iframe>
                @endif
            </div>
            @endforeach
        @endif
        @foreach($videos as $video)
        <div class="aspect-video rounded-xl overflow-hidden">
            <video src="{{ $video->getUrl() }}" controls class="w-full h-full rounded-xl">
                Your browser does not support HTML5 video.
            </video>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-20 text-center" data-animate>
    <div class="container mx-auto px-6">
        <h2 class="font-heading font-bold text-3xl md:text-4xl mb-6">Have a similar challenge?</h2>
        <a href="{{ route('contact') }}"
           class="inline-block bg-[var(--color-accent)] text-[var(--color-bg)] font-semibold px-10 py-4 rounded-full hover:bg-[var(--color-accent-dark)] transition-colors">
            Let's talk →
        </a>
    </div>
</section>

{{-- Prev / Next --}}
<div class="border-t border-[var(--color-border)]">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-2">
            @if($previous)
            <a href="{{ route('project', $previous) }}" class="group py-12 pr-6 border-r border-[var(--color-border)]">
                <p class="text-[var(--color-text-muted)] text-xs uppercase tracking-widest mb-2">← Previous</p>
                <p class="font-heading font-semibold text-lg group-hover:text-[var(--color-accent)] transition-colors">
                    {{ $previous->title }}
                </p>
            </a>
            @else
            <div class="py-12 pr-6 border-r border-[var(--color-border)]"></div>
            @endif
            @if($next)
            <a href="{{ route('project', $next) }}" class="group py-12 pl-6 text-right">
                <p class="text-[var(--color-text-muted)] text-xs uppercase tracking-widest mb-2">Next →</p>
                <p class="font-heading font-semibold text-lg group-hover:text-[var(--color-accent)] transition-colors">
                    {{ $next->title }}
                </p>
            </a>
            @else
            <div class="py-12 pl-6"></div>
            @endif
        </div>
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
    if (window.Splitting) {
        Splitting({ target: '[data-split]', by: 'chars' });
        gsap.from('[data-split] .char', {
            y: '110%', opacity: 0, duration: 0.9,
            stagger: 0.02, ease: 'power4.out', delay: 0.2
        });
    }
    // Parallax cover
    const cover = document.getElementById('project-cover-full');
    if (cover) {
        gsap.to(cover, {
            yPercent: 20, ease: 'none',
            scrollTrigger: { trigger: cover, start: 'top bottom', end: 'bottom top', scrub: true }
        });
    }
});
</script>
@endpush
</x-app-layout>
