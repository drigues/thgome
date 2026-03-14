<x-app-layout :metaTitle="'Blog'">

<section class="pt-40 pb-32">
    <div class="container mx-auto px-6">
        <h1 class="font-heading font-extrabold leading-none mb-16 text-[clamp(60px,10vw,160px)]" data-split>Blog</h1>

        @if($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
            <article class="group" data-animate>
                <a href="{{ route('post', $post) }}">
                    @if($post->cover)
                    <div class="aspect-[4/3] overflow-hidden rounded-lg bg-[var(--color-bg-card)] mb-4">
                        <img src="{{ asset('storage/' . $post->cover) }}" alt="{{ $post->title }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                             loading="lazy">
                    </div>
                    @else
                    <div class="aspect-[4/3] rounded-lg bg-[var(--color-bg-card)] mb-4 flex items-center justify-center">
                        <span class="text-[var(--color-text-muted)] text-4xl font-heading font-bold opacity-20">{{ substr($post->title, 0, 1) }}</span>
                    </div>
                    @endif
                    <div>
                        <p class="text-[var(--color-text-muted)] text-xs mb-2">
                            {{ $post->published_at?->format('d M Y') }}
                        </p>
                        <h2 class="font-heading font-semibold text-lg mb-2 group-hover:text-[var(--color-accent)] transition-colors">
                            {{ $post->title }}
                        </h2>
                        @if($post->excerpt)
                        <p class="text-[var(--color-text-muted)] text-sm line-clamp-2">{{ $post->excerpt }}</p>
                        @endif
                    </div>
                </a>
            </article>
            @endforeach
        </div>

        <div class="mt-16">
            {{ $posts->links() }}
        </div>
        @else
        <p class="text-[var(--color-text-muted)] text-lg" data-animate>No posts yet. Stay tuned!</p>
        @endif
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
});
</script>
@endpush
</x-app-layout>
