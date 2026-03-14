<x-app-layout :metaTitle="$post->meta_title ?? $post->title" :metaDescription="$post->meta_description ?? $post->excerpt">

<article class="pt-40 pb-32">
    <div class="container mx-auto px-6">
        {{-- Header --}}
        <div class="max-w-3xl mx-auto mb-16">
            <p class="text-[var(--color-text-muted)] text-sm mb-4" data-animate>
                {{ $post->published_at?->format('d M Y') }}
            </p>
            <h1 class="font-heading font-extrabold text-4xl md:text-6xl leading-none mb-6" data-split>
                {{ $post->title }}
            </h1>
            @if($post->excerpt)
            <p class="text-[var(--color-text-muted)] text-xl" data-animate>{{ $post->excerpt }}</p>
            @endif
        </div>

        {{-- Cover --}}
        @if($post->cover)
        <div class="max-w-4xl mx-auto mb-16" data-animate>
            <img src="{{ asset('storage/' . $post->cover) }}" alt="{{ $post->title }}"
                 class="w-full rounded-xl aspect-video object-cover">
        </div>
        @endif

        {{-- Content --}}
        @if($post->content)
        <div class="max-w-3xl mx-auto" data-animate>
            <div class="prose-portfolio">
                {!! $post->content !!}
            </div>
        </div>
        @endif
    </div>
</article>

{{-- Back --}}
<div class="border-t border-[var(--color-border)]">
    <div class="container mx-auto px-6 py-12">
        <a href="{{ route('blog') }}" class="text-[var(--color-accent)] hover:underline font-medium">
            ← Back to Blog
        </a>
    </div>
</div>

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
});
</script>
@endpush
</x-app-layout>
