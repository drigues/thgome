<footer class="border-t border-[var(--color-border)] py-12 mt-32">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <p class="text-[var(--color-text-muted)] text-sm font-heading italic">
                "Designing products that matter."
            </p>
            <div class="flex items-center gap-6">
                @if(\App\Models\Setting::get('social_linkedin'))
                <a href="{{ \App\Models\Setting::get('social_linkedin') }}" target="_blank" rel="noopener noreferrer"
                   class="text-[var(--color-text-muted)] hover:text-[var(--color-accent)] transition-colors text-sm font-medium">
                    LinkedIn
                </a>
                @endif
                @if(\App\Models\Setting::get('social_github'))
                <a href="{{ \App\Models\Setting::get('social_github') }}" target="_blank" rel="noopener noreferrer"
                   class="text-[var(--color-text-muted)] hover:text-[var(--color-accent)] transition-colors text-sm font-medium">
                    GitHub
                </a>
                @endif
                @if(\App\Models\Setting::get('social_behance'))
                <a href="{{ \App\Models\Setting::get('social_behance') }}" target="_blank" rel="noopener noreferrer"
                   class="text-[var(--color-text-muted)] hover:text-[var(--color-accent)] transition-colors text-sm font-medium">
                    Behance
                </a>
                @endif
            </div>
            <p class="text-[var(--color-text-muted)] text-xs">
                © {{ date('Y') }} Thiago Rodrigues
            </p>
        </div>
    </div>
</footer>
