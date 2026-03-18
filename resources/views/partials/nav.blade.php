<header id="site-nav" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        x-data="{ open: false, scrolled: false }"
        x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 60)"
        :class="scrolled ? 'bg-[var(--color-bg)]/95 backdrop-blur-sm border-b border-[var(--color-border)]' : ''">
    <nav class="container mx-auto px-6 py-5 flex items-center justify-between">
        <a href="{{ route('home') }}" class="font-heading font-bold text-xl tracking-tight">
            thgo<span class="text-[var(--color-accent)]">.me</span>
        </a>
        <ul class="hidden md:flex items-center gap-8 text-sm font-medium">
            <li><a href="{{ route('projects') }}" class="text-[var(--color-text-muted)] hover:text-[var(--color-text)] transition-colors">Work</a></li>
            <li><a href="{{ route('about') }}" class="text-[var(--color-text-muted)] hover:text-[var(--color-text)] transition-colors">About</a></li>
            <li>
                <span class="flex items-center gap-2 text-[var(--color-text-muted)] text-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse inline-block"></span>
                    Available 2026
                </span>
            </li>
            <li>
                <a href="{{ route('contact') }}"
                   class="bg-[var(--color-accent)] text-[var(--color-bg)] font-semibold px-5 py-2 rounded-full text-sm hover:opacity-90 transition-opacity">
                    Let's talk
                </a>
            </li>
            <li>
                <button onclick="toggleTheme()" id="theme-toggle"
                        class="flex items-center justify-center w-9 h-9 rounded-full border border-[var(--color-border)] hover:border-[var(--color-accent)] transition-colors"
                        aria-label="Toggle theme">
                    <span id="theme-icon-dark" class="text-sm">☾</span>
                    <span id="theme-icon-light" class="text-sm hidden">☀</span>
                </button>
            </li>
        </ul>
        <div class="flex items-center gap-3 md:hidden">
            <button onclick="toggleTheme()" id="theme-toggle-mobile"
                    class="flex items-center justify-center w-9 h-9 rounded-full border border-[var(--color-border)]"
                    aria-label="Toggle theme">
                <span id="theme-icon-dark-mobile" class="text-sm">☾</span>
                <span id="theme-icon-light-mobile" class="text-sm hidden">☀</span>
            </button>
            <button @click="open = !open; $dispatch('menu-toggle', { open: open })"
                    class="flex flex-col gap-1.5 p-2 z-50" aria-label="Menu">
                <span :class="open ? 'rotate-45 translate-y-2' : ''" class="block w-6 h-0.5 bg-current transition-transform duration-300 origin-center"></span>
                <span :class="open ? 'opacity-0' : ''" class="block w-6 h-0.5 bg-current transition-opacity duration-300"></span>
                <span :class="open ? '-rotate-45 -translate-y-2' : ''" class="block w-6 h-0.5 bg-current transition-transform duration-300 origin-center"></span>
            </button>
        </div>
    </nav>
</header>

{{-- Mobile menu — outside header to avoid backdrop-blur stacking context bug on iOS --}}
<div id="mobile-menu"
     class="md:hidden fixed inset-0 z-40 flex-col justify-center px-8 hidden"
     style="background-color: var(--color-bg);">
    <ul class="flex flex-col gap-8">
        <li><a href="{{ route('projects') }}" onclick="closeMobileMenu()" class="font-heading font-bold text-5xl text-[var(--color-text)]">Work</a></li>
        <li><a href="{{ route('about') }}" onclick="closeMobileMenu()" class="font-heading font-bold text-5xl text-[var(--color-text)]">About</a></li>
        <li><a href="{{ route('blog') }}" onclick="closeMobileMenu()" class="font-heading font-bold text-5xl text-[var(--color-text)]">Blog</a></li>
        <li><a href="{{ route('contact') }}" onclick="closeMobileMenu()" class="font-heading font-bold text-5xl text-[var(--color-accent)]">Contact</a></li>
    </ul>
</div>
