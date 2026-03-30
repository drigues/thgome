<x-app-layout>

{{-- HERO --}}
<section class="pt-24 md:pt-32 pb-6 md:pb-12 relative overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="max-w-8xl">
            @if($project->category)
            <span class="text-[var(--color-accent)] font-mono text-xs tracking-widest uppercase mb-4 block" data-animate>
                {{ $project->category->name }}
            </span>
            @endif
            <h1 class="font-heading font-extrabold leading-[1.0] mb-6 text-[clamp(2rem,5.5vw,90px)]" data-animate>
                {{ $project->title }}
            </h1>
            @if($project->excerpt)
            <p class="text-[var(--color-text-muted)] text-xl max-w-2xl" data-animate>{{ $project->excerpt }}</p>
            @endif
        </div>
        <div class="flex flex-wrap gap-10 mt-10 pt-10 border-t border-[var(--color-border)]" data-animate>
            @if($project->client)
            <div>
                <p class="text-[var(--color-text-muted)] text-xs uppercase tracking-widest mb-1">Client</p>
                <p class="font-medium text-sm">{{ $project->client }}</p>
            </div>
            @endif
            @if($project->year)
            <div>
                <p class="text-[var(--color-text-muted)] text-xs uppercase tracking-widest mb-1">Year</p>
                <p class="font-medium text-sm">{{ $project->year }}</p>
            </div>
            @endif
            @if($project->url)
            <div>
                <p class="text-[var(--color-text-muted)] text-xs uppercase tracking-widest mb-1">Link</p>
                <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer"
                   class="font-medium text-sm text-[var(--color-accent)] hover:underline">
                    Visit project →
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- COVER IMAGE — responsive aspect ratio --}}
@if($project->getFirstMediaUrl('cover'))
<div class="w-full overflow-hidden" data-animate>
    <img src="{{ $project->getFirstMediaUrl('cover') }}"
         alt="{{ $project->title }}"
         class="w-full aspect-[4/3] md:aspect-video object-cover object-center"
         loading="eager">
</div>
@endif

{{-- PITCH VIDEO — only shown if uploaded --}}
@php $pitchUrl = $project->getFirstMediaUrl('pitch'); @endphp
@if($pitchUrl)
<div class="container mx-auto px-6 py-10 md:py-16" data-animate>
    <div class="max-w-4xl mx-auto">
        <p class="text-xs font-mono uppercase tracking-widest text-[var(--color-text-muted)] mb-4">Project Pitch</p>
        <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-[var(--color-bg-card)] shadow-xl"
             x-data="{ playing: false }">
            <div x-show="!playing"
                 class="absolute inset-0 flex items-center justify-center cursor-pointer group z-10 bg-[var(--color-bg-card)]"
                 @click="playing = true">
                <div class="w-16 h-16 rounded-full flex items-center justify-center transition-transform duration-300 group-hover:scale-110 shadow-lg"
                     style="background: var(--color-accent)">
                    <svg class="w-6 h-6 ml-1" viewBox="0 0 24 24" fill="var(--color-bg)">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </div>
                <p class="absolute bottom-4 left-4 text-[var(--color-text-muted)] text-xs uppercase tracking-widest font-medium">
                    Play
                </p>
            </div>
            <template x-if="playing">
                <video src="{{ $pitchUrl }}"
                       class="absolute inset-0 w-full h-full object-cover"
                       controls autoplay playsinline>
                </video>
            </template>
        </div>
    </div>
</div>
@endif

{{-- DESCRIPTION PART 1 --}}
@if($project->description)
<section class="py-10 md:py-10">
    <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-[1fr_280px] gap-16 items-start max-w-6xl mx-auto">
            <div class="prose-portfolio min-w-0">
                {!! $project->description !!}
            </div>
            <aside class="hidden lg:block">
                <div class="sticky top-32 space-y-3 mt-12">
                    <p class="text-xs font-mono uppercase tracking-widest text-[var(--color-text-muted)] mb-4 pt-4">On this page</p>
                    @php
                        preg_match_all('/<h2[^>]*>(.*?)<\/h2>/i', ($project->description ?? '') . ($project->description_two ?? ''), $matches);
                        $headings = $matches[1] ?? [];
                    @endphp
                    @foreach($headings as $heading)
                    <div class="border-l-2 border-[var(--color-border)] pl-4 py-1 hover:border-[var(--color-accent)] transition-colors">
                        <p class="text-xs text-[var(--color-text-muted)] leading-snug">{{ strip_tags($heading) }}</p>
                    </div>
                    @endforeach
                    @if($project->url)
                    <div class="pt-4">
                        <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer"
                           class="text-sm font-medium text-[var(--color-accent)] hover:underline">
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

{{-- IMAGE BLOCK (between descriptions) --}}
@php
    $imageBlock = $project->getMedia('image_block');
    $blockLayout = $project->image_block_layout ?? 'grid-2';
@endphp
@if($imageBlock->count() && $blockLayout !== 'none')
<section class="py-2 md:py-2" x-data="{ isOpen: false, currentImage: '' }">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto">

            @if($blockLayout === 'full')
            {{-- Full width --}}
            <div class="space-y-4">
                @foreach($imageBlock as $media)
                <div class="w-full overflow-hidden rounded-xl cursor-pointer" @click="currentImage = '{{ $media->getUrl() }}'; isOpen = true">
                    <img src="{{ $media->getUrl() }}" alt="{{ $project->title }}"
                         class="w-full h-auto hover:scale-[1.01] transition-transform duration-500" loading="lazy">
                </div>
                @endforeach
            </div>

            @elseif($blockLayout === 'grid-2')
            {{-- 2 columns --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($imageBlock as $media)
                <div class="overflow-hidden rounded-xl cursor-pointer" @click="currentImage = '{{ $media->getUrl() }}'; isOpen = true">
                    <img src="{{ $media->getUrl() }}" alt="{{ $project->title }}"
                         class="w-full h-auto hover:scale-[1.02] transition-transform duration-500" loading="lazy">
                </div>
                @endforeach
            </div>

            @elseif($blockLayout === 'grid-3')
            {{-- 3 columns --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($imageBlock as $media)
                <div class="overflow-hidden rounded-xl cursor-pointer" @click="currentImage = '{{ $media->getUrl() }}'; isOpen = true">
                    <img src="{{ $media->getUrl() }}" alt="{{ $project->title }}"
                         class="w-full h-auto hover:scale-[1.02] transition-transform duration-500" loading="lazy">
                </div>
                @endforeach
            </div>

            @elseif($blockLayout === 'featured')
            {{-- Featured: first large, rest small --}}
            <div class="space-y-4">
                @foreach($imageBlock as $i => $media)
                @if($i === 0)
                <div class="w-full overflow-hidden rounded-xl cursor-pointer" @click="currentImage = '{{ $media->getUrl() }}'; isOpen = true">
                    <img src="{{ $media->getUrl() }}" alt="{{ $project->title }}"
                         class="w-full h-auto" loading="lazy">
                </div>
                @elseif($i === 1)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @endif
                @if($i > 0)
                <div class="overflow-hidden rounded-xl cursor-pointer" @click="currentImage = '{{ $media->getUrl() }}'; isOpen = true">
                    <img src="{{ $media->getUrl() }}" alt="{{ $project->title }}"
                         class="w-full h-auto hover:scale-[1.02] transition-transform duration-500" loading="lazy">
                </div>
                @if($loop->last && $i > 0)</div>@endif
                @endif
                @endforeach
            </div>
            @endif

            {{-- Lightbox --}}
            <div x-show="isOpen" x-transition
                 class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4"
                 @click.self="isOpen = false"
                 @keydown.escape.window="isOpen = false">
                <button @click="isOpen = false"
                        class="absolute top-6 right-6 text-white/70 hover:text-white text-3xl leading-none">✕</button>
                <img :src="currentImage" class="max-h-[90vh] max-w-[90vw] object-contain rounded-xl">
            </div>

        </div>
    </div>
</section>
@endif

{{-- DESCRIPTION PART 2 --}}
@if($project->description_two)
<section class="py-10 md:py-10">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto">
            <div class="prose-portfolio min-w-0 lg:max-w-[calc(100%-316px)]">
                {!! $project->description_two !!}
            </div>
        </div>
    </div>
</section>
@endif

{{-- GALLERY (existing, kept as before) --}}
@php $gallery = $project->getMedia('gallery'); @endphp
@if($gallery->count())
<section class="py-12 bg-[var(--color-bg-alt)]" x-data="{ isOpen: false, currentImage: '' }">
    <div class="container mx-auto px-6">
        <p class="text-xs font-mono uppercase tracking-widest text-[var(--color-text-muted)] mb-8">Resources</p>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 lg:gap-4 max-w-6xl mx-auto">
            @foreach($gallery as $i => $media)
            <div class="{{ $i === 0 ? 'col-span-2 row-span-2' : '' }} overflow-hidden rounded-xl cursor-pointer aspect-square"
                 @click="currentImage = '{{ $media->getUrl() }}'; isOpen = true">
                <img src="{{ $media->getUrl() }}" alt="{{ $project->title }}"
                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-700" loading="lazy">
            </div>
            @endforeach
            <div x-show="isOpen" x-transition
                 class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4"
                 @click.self="isOpen = false" @keydown.escape.window="isOpen = false">
                <button @click="isOpen = false" class="absolute top-6 right-6 text-white/70 hover:text-white text-3xl">✕</button>
                <img :src="currentImage" class="max-h-[90vh] max-w-[90vw] object-contain rounded-xl">
            </div>
        </div>
    </div>
</section>
@endif

{{-- VIDEOS (embed + file, existing) --}}
@php $videos = $project->getMedia('videos'); @endphp
@if($project->video_embeds || $videos->count())
<section class="py-12 container mx-auto px-6">
    <p class="text-xs font-mono uppercase tracking-widest text-[var(--color-text-muted)] mb-8">Videos</p>
    <div class="grid md:grid-cols-2 gap-6 max-w-6xl mx-auto">
        @if($project->video_embeds)
            @foreach($project->video_embeds as $embed)
            <div class="aspect-video rounded-xl overflow-hidden">
                @if($embed['platform'] === 'youtube')
                <iframe src="https://www.youtube.com/embed/{{ $embed['embed_id'] }}"
                        class="w-full h-full" allowfullscreen loading="lazy"></iframe>
                @elseif($embed['platform'] === 'vimeo')
                <iframe src="https://player.vimeo.com/video/{{ $embed['embed_id'] }}"
                        class="w-full h-full" allowfullscreen loading="lazy"></iframe>
                @endif
            </div>
            @endforeach
        @endif
        @foreach($videos as $video)
        <div class="aspect-video rounded-xl overflow-hidden">
            <video src="{{ $video->getUrl() }}" controls class="w-full h-full rounded-xl"></video>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-20 text-center border-t border-[var(--color-border)]">
    <div class="container mx-auto px-6">
        <p class="text-[var(--color-text-muted)] mb-6">Have a similar challenge?</p>
        <a href="{{ route('contact') }}"
           class="inline-block bg-[var(--color-accent)] text-[var(--color-bg)] font-heading font-bold px-8 py-4 rounded-full hover:opacity-90 transition-opacity">
            Let's talk →
        </a>
    </div>
</section>

{{-- PREV / NEXT --}}
<div class="container mx-auto px-6 py-16 border-t border-[var(--color-border)]">
    <div class="flex justify-between gap-8">
        @if($previous)
        <a href="{{ route('project', $previous) }}" class="group">
            <p class="text-[var(--color-text-muted)] text-xs uppercase tracking-widest mb-2">← Previous</p>
            <p class="font-heading font-semibold text-lg group-hover:text-[var(--color-accent)] transition-colors">{{ $previous->title }}</p>
        </a>
        @else<div></div>@endif
        @if($next)
        <a href="{{ route('project', $next) }}" class="group text-right">
            <p class="text-[var(--color-text-muted)] text-xs uppercase tracking-widest mb-2">Next →</p>
            <p class="font-heading font-semibold text-lg group-hover:text-[var(--color-accent)] transition-colors">{{ $next->title }}</p>
        </a>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.Splitting) {
        Splitting({ target: 'h1', by: 'chars' });
        gsap.from('h1 .char', {
            y: '100%', opacity: 0, duration: 0.8,
            stagger: 0.02, ease: 'power4.out', delay: 0.1
        });
    }
    gsap.utils.toArray('[data-animate]').forEach(el => {
        gsap.fromTo(el,
            { y: 40, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out',
              scrollTrigger: { trigger: el, start: 'top 88%' } }
        );
    });
    @if($project->getFirstMediaUrl('cover'))
    gsap.to('.cover-parallax', {
        yPercent: 15, ease: 'none',
        scrollTrigger: { trigger: '.cover-parallax', start: 'top top', end: 'bottom top', scrub: true }
    });
    @endif
});
</script>
@endpush

</x-app-layout>
