<x-app-layout :metaTitle="'About'">

{{-- HERO --}}
<section class="pt-24 md:pt-40 pb-20">
    <div class="container mx-auto px-6">
        <p class="text-[var(--color-accent)] font-mono text-xs tracking-[0.25em] uppercase mb-8" data-animate>About</p>
        <h1 class="font-heading font-extrabold leading-none text-[clamp(48px,9vw,140px)]" data-split>Designer.<br>Builder.<br>Systems thinker.</h1>
    </div>
</section>

{{-- BIO --}}
<section class="pb-32">
    <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-start">
            <div data-animate>
                <p class="text-[var(--color-text-muted)] text-lg leading-relaxed mb-6">
                    I'm Thiago Rodrigues — a Product Designer with 10+ years of experience turning complex challenges into clear, purposeful digital products.
                </p>
                <p class="text-[var(--color-text-muted)] text-lg leading-relaxed mb-6">
                    I've led end-to-end design for enterprise SaaS, fintech, and healthcare platforms — shipping products used by thousands. My approach blends systems thinking with hands-on prototyping and a deep understanding of front-end engineering.
                </p>
                <p class="text-[var(--color-text-muted)] text-lg leading-relaxed">
                    Currently based in Portugal, working remotely across time zones.
                </p>
            </div>
            <div data-animate>
                @if(\App\Models\Setting::get('about_cv_url'))
                <a href="{{ asset('storage/' . \App\Models\Setting::get('about_cv_url')) }}" target="_blank"
                   class="inline-flex items-center gap-3 bg-[var(--color-accent)] text-[var(--color-bg)] font-semibold px-8 py-4 rounded-full hover:bg-[var(--color-accent-dark)] transition-colors mb-8">
                    Download CV ↓
                </a>
                @endif
                <div class="grid grid-cols-3 gap-4">
                    @foreach([['EN','C1'],['ES','B1'],['PT','Native']] as $lang)
                    <div class="border border-[var(--color-border)] rounded-xl p-4 text-center">
                        <p class="font-heading font-bold text-2xl text-[var(--color-accent)]">{{ $lang[0] }}</p>
                        <p class="text-[var(--color-text-muted)] text-xs mt-1">{{ $lang[1] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>


{{-- EDUCATION --}}
<section class="py-32">
    <div class="container mx-auto px-6">
        <p class="text-[var(--color-accent)] font-mono text-xs tracking-widest uppercase mb-4" data-animate>Education</p>
        <h2 class="font-heading font-bold text-4xl md:text-5xl mb-16" data-animate>Academic Background</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="border border-[var(--color-border)] rounded-2xl p-8" data-animate>
                <p class="text-[var(--color-accent)] font-mono text-xs tracking-widest mb-2">2026 — 2028</p>
                <h3 class="font-heading font-semibold text-xl mb-1">CENFIM</h3>
                <p class="text-[var(--color-text-muted)] text-sm font-semibold">Technical in Robotics and Industrial Automation</p>
                <p class="text-[var(--color-text-muted)] text-sm mt-1">Caldas da Rainha, Portugal</p>
            </div>
            <div class="border border-[var(--color-border)] rounded-2xl p-8" data-animate>
                <p class="text-[var(--color-accent)] font-mono text-xs tracking-widest mb-2">2022 — 2023</p>
                <h3 class="font-heading font-semibold text-xl mb-1">IADE — Universidade Europeia</h3>
                <p class="text-[var(--color-text-muted)] text-sm font-semibold">Advanced Programme in Design Thinking and Innovation</p>
                <p class="text-[var(--color-text-muted)] text-sm mt-1">Lisbon, Portugal</p>
            </div>
            <div class="border border-[var(--color-border)] rounded-2xl p-8" data-animate>
                <p class="text-[var(--color-accent)] font-mono text-xs tracking-widest mb-2">2015 — 2018</p>
                <h3 class="font-heading font-semibold text-xl mb-1">College of Computing Technology</h3>
                <p class="text-[var(--color-text-muted)] text-sm font-semibold">Bachelor of Science in Information Technology</p>
                <p class="text-[var(--color-text-muted)] text-sm mt-1">Dublin, Ireland</p>
            </div>
        </div>
    </div>
</section>

{{-- SKILLS --}}
<section class="py-32">
    <div class="container mx-auto px-6">
        <p class="text-[var(--color-accent)] font-mono text-xs tracking-widest uppercase mb-4" data-animate>Skills</p>
        <h2 class="font-heading font-bold text-4xl md:text-5xl mb-16" data-animate>What I bring</h2>
        <div class="grid md:grid-cols-3 gap-8">
            {{-- Foundation --}}
            <div class="border border-[var(--color-border)] rounded-2xl p-8" data-animate>
                <p class="text-[var(--color-accent)] font-mono text-xs tracking-widest uppercase mb-2">Foundation · 10+ yrs</p>
                <h3 class="font-heading font-semibold text-xl mb-6">Design Core</h3>
                <ul class="space-y-3 text-[var(--color-text-muted)] text-sm">
                    @foreach(['Product Design','UX Research','Interaction Design','Visual Design','Design Systems','Information Architecture','Accessibility (WCAG)','Responsive & Adaptive Design'] as $skill)
                    <li class="flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-[var(--color-accent)]"></span>{{ $skill }}</li>
                    @endforeach
                </ul>
            </div>
            {{-- Process & Tools --}}
            <div class="border border-[var(--color-border)] rounded-2xl p-8" data-animate>
                <p class="text-[var(--color-accent)] font-mono text-xs tracking-widest uppercase mb-2">Process & Tools · 5+ yrs</p>
                <h3 class="font-heading font-semibold text-xl mb-6">Craft & Workflow</h3>
                <ul class="space-y-3 text-[var(--color-text-muted)] text-sm">
                    @foreach(['Figma & FigJam','Prototyping (Principle, Framer)','User Testing & Analytics','Design Tokens & Theming','Storybook','Agile / Scrum / Kanban','Stakeholder Management','Cross-functional Leadership'] as $skill)
                    <li class="flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-[var(--color-accent)]"></span>{{ $skill }}</li>
                    @endforeach
                </ul>
            </div>
            {{-- AI & Technical --}}
            <div class="border border-[var(--color-border)] rounded-2xl p-8" data-animate>
                <p class="text-[var(--color-accent)] font-mono text-xs tracking-widest uppercase mb-2">AI & Technical · Growing fast</p>
                <h3 class="font-heading font-semibold text-xl mb-6">Engineering & AI</h3>
                <ul class="space-y-3 text-[var(--color-text-muted)] text-sm">
                    @foreach(['HTML / CSS / Tailwind','JavaScript / TypeScript','React / Next.js','Laravel / PHP','AI Prompt Engineering','Claude / GPT Integration','Python (data viz)','Git & CI/CD'] as $skill)
                    <li class="flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-[var(--color-accent)]"></span>{{ $skill }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- TIMELINE --}}
<section class="py-32 bg-[var(--color-bg-alt)]">
    <div class="container mx-auto px-6">
        <p class="text-[var(--color-accent)] font-mono text-xs tracking-widest uppercase mb-4" data-animate>Experience</p>
        <h2 class="font-heading font-bold text-4xl md:text-5xl mb-16" data-animate>Timeline</h2>
        <div class="space-y-0 border-l-2 border-[var(--color-border)] ml-4">
            @foreach([
                ['2025 — Present','Product Builder','Thr33 Studio (Óbidos/Portugal)','Building digital products for the portuguese market'],
                ['2023 — 2025','User Experience Designer','McKesson (USA - Remote)','Enterprise healthcare platform — redesigning clinical workflows for 75,000+ users across North America.'],
                ['2023 — 2023','UX/UI Designer','BladeInsight (Portugal - Hybrid)','Built and scaled design system from scratch for IoT wind-energy platform. Led cross-functional team of 8.'],
                ['2021 — 2023','UX Generalist','MindTools (Edinburgh/UK - Remote)','Redesigned the core learning experience for 30M+ global users. Led research sprints and shipped 3 major features.'],
                ['2019 — 2021','Service Designer','Montepascual (Ceará/Brazil)','Managing teams, projects, and events for the co-brands under SDG Actions, Customer Experience, Branding, Marketing, Sales Strategy, and Social Media.'],
                ['2015 — 2019','UX/UI Designer','Progress Systems (Dublin/Ireland)','Fintech products — payment processing dashboards, merchant onboarding, compliance workflows.'],
                ['2016 — 2017','Product Designer','Granber (Dublin/Ireland)','Full-stack web design for industrial textiles. E-commerce, B2B portal, product configurator.'],
                ['2011 — 2015','Web Designer','Freelancer','Consultant, product developer, and UX/UI designer delivering digital products across Ireland, Chile, and Brazil.'],
                ['2008 — 2011','Web Designer','Edson Queiroz Group (Ceará/Brazil)','Visual design and marketing materials for one of Brazil\'s largest conglomerates.'],
            ] as $entry)
            <div class="relative pl-10 pb-12" data-animate>
                <div class="absolute left-0 top-1 w-3 h-3 rounded-full bg-[var(--color-accent)] -translate-x-[7px]"></div>
                <p class="text-[var(--color-accent)] font-mono text-xs tracking-widest mb-1">{{ $entry[0] }}</p>
                <h3 class="font-heading font-semibold text-xl mb-1">{{ $entry[1] }}</h3>
                <p class="font-medium text-[var(--color-text-muted)] text-sm mb-2">{{ $entry[2] }}</p>
                <p class="text-[var(--color-text-muted)] text-sm leading-relaxed">{{ $entry[3] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- RECOGNITION --}}
<section class="py-32 bg-[var(--color-bg-alt)]">
    <div class="container mx-auto px-6">
        <p class="text-[var(--color-accent)] font-mono text-xs tracking-widest uppercase mb-4" data-animate>Recognition</p>
        <h2 class="font-heading font-bold text-4xl md:text-5xl mb-16" data-animate>Awards & Features</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="border border-[var(--color-border)] rounded-2xl p-8" data-animate>
                <p class="text-[var(--color-accent)] font-heading font-bold text-3xl mb-2">Google for Entrepreneurs</p>
                <p class="font-heading font-semibold text-xl mb-3">2ND Place of Startup Weekend Utrecht (The Netherlands)</p>
                <p class="text-[var(--color-text-muted)] text-sm leading-relaxed">Gameday - Product Designer - NOV 2017</p>
            </div>
            <div class="border border-[var(--color-border)] rounded-2xl p-8" data-animate>
                <p class="text-[var(--color-accent)] font-heading font-bold text-3xl mb-2">Google for Entrepreneurs</p>
                <p class="font-heading font-semibold text-xl mb-3">Winner of Startup Weekend Limerick (Ireland)</p>
                <p class="text-[var(--color-text-muted)] text-sm leading-relaxed">Emojo Watch - Visual / User Experience Designer - NOV 2015</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-32 text-center" data-animate>
    <div class="container mx-auto px-6">
        <h2 class="font-heading font-bold text-4xl md:text-5xl mb-6">Let's work together</h2>
        <p class="text-[var(--color-text-muted)] text-lg mb-10">I'm available for new projects in 2026.</p>
        <a href="{{ route('contact') }}"
           class="inline-block bg-[var(--color-accent)] text-[var(--color-bg)] font-semibold px-10 py-4 rounded-full hover:bg-[var(--color-accent-dark)] transition-colors">
            Get in touch →
        </a>
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
