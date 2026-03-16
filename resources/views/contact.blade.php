<x-app-layout :metaTitle="'Contact'">

<section class="pt-40 pb-32">
    <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-20">
            {{-- Left: Info --}}
            <div>
                <h1 class="font-heading font-extrabold leading-none mb-10 text-[clamp(48px,8vw,100px)]" data-split>Let's build<br>some-<br>thing.</h1>

                <div class="flex items-center gap-3 mb-8" data-animate>
                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                    <span class="text-[var(--color-text-muted)] text-sm">Available for new projects — 2026</span>
                </div>

                <div class="space-y-4 mb-10" data-animate>
                    @if(\App\Models\Setting::get('contact_email'))
                    <a href="mailto:{{ \App\Models\Setting::get('contact_email') }}"
                       class="flex items-center gap-3 text-[var(--color-text-muted)] hover:text-[var(--color-accent)] transition-colors">
                        <span class="text-[var(--color-accent)]">✉</span>
                        {{ \App\Models\Setting::get('contact_email') }}
                    </a>
                    @endif
                    @if(\App\Models\Setting::get('contact_phone'))
                    <a href="tel:{{ \App\Models\Setting::get('contact_phone') }}"
                       class="flex items-center gap-3 text-[var(--color-text-muted)] hover:text-[var(--color-accent)] transition-colors">
                        <span class="text-[var(--color-accent)]">☎</span>
                        {{ \App\Models\Setting::get('contact_phone') }}
                    </a>
                    @endif
                </div>

                <p class="text-[var(--color-text-muted)] text-sm" data-animate>
                    Based in Portugal (WET/UTC+0)
                </p>
            </div>

            {{-- Right: Form --}}
            <div x-data="contactForm()" data-animate>
                <form @submit.prevent="submit" class="space-y-6" novalidate>
                    {{-- Honeypot --}}
                    <input type="text" name="website" x-model="form.website" class="hidden" tabindex="-1" autocomplete="off">

                    <div>
                        <input type="text" x-model="form.name" placeholder="Name *"
                               class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border)] rounded-lg px-5 py-4 text-[var(--color-text)] placeholder-[var(--color-text-muted)] focus:outline-none focus:border-[var(--color-accent)] transition-colors">
                    </div>
                    <div>
                        <input type="email" x-model="form.email" placeholder="Email *"
                               class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border)] rounded-lg px-5 py-4 text-[var(--color-text)] placeholder-[var(--color-text-muted)] focus:outline-none focus:border-[var(--color-accent)] transition-colors">
                    </div>
                    <div>
                        <input type="text" x-model="form.subject" placeholder="Subject"
                               class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border)] rounded-lg px-5 py-4 text-[var(--color-text)] placeholder-[var(--color-text-muted)] focus:outline-none focus:border-[var(--color-accent)] transition-colors">
                    </div>
                    <div>
                        <textarea x-model="form.message" placeholder="Message *" rows="5"
                                  class="w-full bg-[var(--color-bg-card)] border border-[var(--color-border)] rounded-lg px-5 py-4 text-[var(--color-text)] placeholder-[var(--color-text-muted)] focus:outline-none focus:border-[var(--color-accent)] transition-colors resize-none"></textarea>
                    </div>

                    <button type="submit" :disabled="loading"
                            class="w-full bg-[var(--color-accent)] text-[var(--color-bg)] font-semibold py-4 rounded-lg hover:bg-[var(--color-accent-dark)] transition-colors disabled:opacity-50">
                        <span x-show="!loading">Send Message</span>
                        <span x-show="loading">Sending...</span>
                    </button>

                    <div x-show="success" x-transition class="p-4 bg-green-900/30 border border-green-700/50 rounded-lg text-green-400 text-sm">
                        ✓ Message sent successfully! I'll get back to you shortly.
                    </div>
                    <div x-show="error" x-transition class="p-4 bg-red-900/30 border border-red-700/50 rounded-lg text-red-400 text-sm">
                        ✕ Something went wrong. Please try again.
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function contactForm() {
    return {
        form: { name: '', email: '', subject: '', message: '', website: '' },
        loading: false, success: false, error: false,
        async submit() {
            this.loading = true; this.success = false; this.error = false;
            try {
                const res = await fetch('{{ route("contact.submit") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(this.form),
                });
                const data = await res.json();
                if (data.success) {
                    this.success = true;
                    this.form = { name: '', email: '', subject: '', message: '', website: '' };
                } else { this.error = true; }
            } catch { this.error = true; }
            finally { this.loading = false; }
        }
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
});
</script>
@endpush
</x-app-layout>
