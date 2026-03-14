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
