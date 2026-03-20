<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thiago Rodrigues — Product Designer CV</title>
    <meta name="robots" content="noindex, nofollow">
    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Screen styles */
        body {
            font-family: var(--font-body, 'Inter', sans-serif);
            background-color: var(--color-bg, #F5F4F0);
            color: var(--color-text, #111111);
            max-width: 860px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        .cv-header { margin-bottom: 2rem; border-bottom: 2px solid var(--color-accent, #111); padding-bottom: 1.5rem; }
        .cv-name { font-family: 'Syne', sans-serif; font-size: 2.5rem; font-weight: 800; line-height: 1; margin: 0 0 0.25rem; }
        .cv-role { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 600; color: var(--color-accent, #111); text-transform: uppercase; letter-spacing: 0.1em; margin: 0 0 0.75rem; }
        .cv-contacts { display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.8rem; color: var(--color-text-muted, #555); }
        .cv-contacts a { color: inherit; text-decoration: none; }

        .cv-section { margin-bottom: 1.5rem; }
        .cv-section-title {
            font-family: 'Syne', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--color-accent, #111);
            border-bottom: 1px solid currentColor;
            padding-bottom: 0.25rem;
            margin-bottom: 0.875rem;
        }

        .cv-profile { font-size: 0.85rem; line-height: 1.7; color: var(--color-text-muted, #555); }

        .cv-skills-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; }
        .cv-skill-block { font-size: 0.78rem; line-height: 1.6; }
        .cv-skill-label { font-weight: 600; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--color-text-muted, #555); margin-bottom: 0.2rem; }

        .cv-job { margin-bottom: 1.25rem; }
        .cv-job-header { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 0.2rem; }
        .cv-job-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.9rem; }
        .cv-job-dates { font-size: 0.75rem; color: var(--color-text-muted, #555); font-family: 'Inter', monospace; white-space: nowrap; }
        .cv-job-company { font-size: 0.78rem; color: var(--color-text-muted, #555); margin-bottom: 0.4rem; }
        .cv-job ul { margin: 0; padding-left: 1rem; }
        .cv-job ul li { font-size: 0.8rem; line-height: 1.6; color: var(--color-text-muted, #555); margin-bottom: 0.15rem; }

        .cv-edu-item { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 0.5rem; }
        .cv-edu-degree { font-weight: 600; font-size: 0.83rem; }
        .cv-edu-school { font-size: 0.78rem; color: var(--color-text-muted, #555); }
        .cv-edu-year { font-size: 0.75rem; color: var(--color-text-muted, #555); white-space: nowrap; }

        .cv-two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }

        .cv-lang-item { display: flex; justify-content: space-between; font-size: 0.82rem; margin-bottom: 0.35rem; }
        .cv-lang-level { color: var(--color-text-muted, #555); font-size: 0.75rem; }

        .cv-print-btn {
            position: fixed; bottom: 2rem; right: 2rem;
            background: var(--color-accent, #111);
            color: var(--color-bg, #F5F4F0);
            border: none; padding: 0.75rem 1.5rem;
            font-family: 'Syne', sans-serif; font-weight: 700;
            font-size: 0.85rem; border-radius: 999px;
            cursor: pointer; letter-spacing: 0.05em;
        }

        /* PRINT STYLES — A4 2 pages max */
        @media print {
            @page {
                size: A4;
                margin: 14mm 16mm;
            }

            body {
                background: white !important;
                color: #111 !important;
                max-width: 100%;
                padding: 0;
                font-size: 9pt;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .cv-print-btn { display: none !important; }

            .cv-name { font-size: 22pt; }
            .cv-role { font-size: 8pt; }
            .cv-contacts { font-size: 7.5pt; gap: 0.6rem; }
            .cv-section-title { font-size: 6pt; }
            .cv-profile { font-size: 8pt; line-height: 1.5; }
            .cv-job-title { font-size: 8.5pt; }
            .cv-job-company { font-size: 7.5pt; }
            .cv-job ul li { font-size: 7.5pt; line-height: 1.45; margin-bottom: 1pt; }
            .cv-edu-degree { font-size: 8pt; }
            .cv-edu-school { font-size: 7.5pt; }
            .cv-skill-block { font-size: 7.5pt; line-height: 1.5; }
            .cv-skill-label { font-size: 6.5pt; }

            .cv-header { padding-bottom: 8pt; margin-bottom: 10pt; }
            .cv-section { margin-bottom: 10pt; }
            .cv-job { margin-bottom: 8pt; }

            /* Force page break before education if needed */
            .cv-section.education { page-break-before: auto; }

            /* Accent color in print */
            .cv-section-title, .cv-role { color: #1a1a1a !important; }
        }
    </style>
</head>
<body>

<button class="cv-print-btn" onclick="window.print()">Export PDF →</button>

{{-- HEADER --}}
<header class="cv-header">
    <h1 class="cv-name">Thiago Rodrigues</h1>
    <p class="cv-role">Product Designer</p>
    <div class="cv-contacts">
        <a href="mailto:thgo.me@outlook.com">thgo.me@outlook.com</a>
        <span>+351 939 341 853</span>
        <a href="https://thgo.me" target="_blank">thgo.me</a>
        <a href="https://linkedin.com/in/thgorodrigues" target="_blank">linkedin.com/in/thgorodrigues</a>
    </div>
</header>

{{-- PROFILE --}}
<section class="cv-section">
    <h2 class="cv-section-title">Profile</h2>
    <p class="cv-profile">Product Designer with 10+ years of experience delivering end-to-end digital products for enterprise corporations and growth-stage startups across healthcare, renewable energy, EdTech, and finance. I work across the full design process — from discovery and research through to high-fidelity interfaces and post-launch iteration — always grounded in user insights and connected to measurable business outcomes. My background combines strategic UX thinking with hands-on technical fluency, having worked across markets in the USA, UK, Portugal, Ireland, Chile, and Brazil.</p>
</section>

{{-- SKILLS --}}
<section class="cv-section">
    <h2 class="cv-section-title">Skills & Expertise</h2>
    <div class="cv-skills-grid">
        <div class="cv-skill-block">
            <div class="cv-skill-label">10+ years</div>
            Product Design (web & mobile), UI Design, Interaction Design, Usability & Accessibility (WCAG 2.2), Design Systems, Information Architecture, Front-end Development, Branding
        </div>
        <div class="cv-skill-block">
            <div class="cv-skill-label">5+ years</div>
            Figma, Lean Startup, Agile & Scrum, Design Thinking, User Research, Journey Mapping, Usability Testing (Maze, TryMyUI), Heuristic Evaluation, OKRs & KPIs, AI-assisted workflows
        </div>
        <div class="cv-skill-block" style="margin-top:0.5rem">
            <div class="cv-skill-label">Technical</div>
            Full-Stack Dev (Laravel, Rails, Python, JS), Git, Hotjar, LogRocket, Data Analysis, Business Intelligence
        </div>
        <div class="cv-skill-block" style="margin-top:0.5rem">
            <div class="cv-skill-label">AI Tools</div>
            Figma Make, v0.dev, Claude Code, Lovable, Copilot, Dovetail AI, NotebookLM, Figma AI
        </div>
    </div>
</section>

{{-- EXPERIENCE --}}
<section class="cv-section">
    <h2 class="cv-section-title">Work Experience</h2>

    <div class="cv-job">
        <div class="cv-job-header">
            <span class="cv-job-title">User Experience Designer</span>
            <span class="cv-job-dates">May 2023 – Jul 2025</span>
        </div>
        <div class="cv-job-company">McKesson (USA remote) · via Randstad Digital</div>
        <ul>
            <li>Led end-to-end design across discovery, definition, and delivery for an enterprise healthcare distribution platform used by tens of thousands of professionals</li>
            <li>Conducted user interviews, facilitated cross-functional workshops, and mapped complex workflows to identify friction points and growth opportunities</li>
            <li>Designed high-fidelity interfaces within a large-scale Design System across multiple product squads, introducing design review rituals and aligning decisions with measurable OKRs</li>
        </ul>
    </div>

    <div class="cv-job">
        <div class="cv-job-header">
            <span class="cv-job-title">UX/UI Designer</span>
            <span class="cv-job-dates">Feb 2023 – May 2023</span>
        </div>
        <div class="cv-job-company">BladeInsight · Lisbon, Portugal</div>
        <ul>
            <li>Established UX practices and design maturity from zero for a renewable energy startup building Web Inspection and Robotics Control platforms</li>
            <li>Initiated the product Design System with dynamic, reusable Figma components; conducted user interviews and usability tests across technical and non-technical profiles</li>
        </ul>
    </div>

    <div class="cv-job">
        <div class="cv-job-header">
            <span class="cv-job-title">UX Generalist</span>
            <span class="cv-job-dates">Apr 2021 – Feb 2023</span>
        </div>
        <div class="cv-job-company">MindTools · Edinburgh, UK remote · via DevSquad</div>
        <ul>
            <li>Shaped B2B and B2C product experiences for a learning platform with 2M+ professionals, contributing to measurable improvements in engagement and feature adoption</li>
            <li>Built Design System components in Figma, ran discovery workshops, and conducted ongoing user research including moderated usability tests and behavioural analysis</li>
        </ul>
    </div>

    <div class="cv-job">
        <div class="cv-job-header">
            <span class="cv-job-title">UX/UI Designer</span>
            <span class="cv-job-dates">Dec 2015 – Mar 2019</span>
        </div>
        <div class="cv-job-company">Progress Systems · Dublin, Ireland</div>
        <ul>
            <li>Designed financial websites, online banking, and mobile banking experiences end-to-end; delivered 200+ CSS components, a full UI Design System, and measurable CTR improvements</li>
        </ul>
    </div>

    <div class="cv-job">
        <div class="cv-job-header">
            <span class="cv-job-title">Founder & Director of Product</span>
            <span class="cv-job-dates">2024 – Present</span>
        </div>
        <div class="cv-job-company">Thr33 (SaaS Holding) · Portugal</div>
        <ul>
            <li>Building two live products: Navego (trust marketplace for 300K+ Brazilian immigrants in Portugal) and 99web (web agency platform with AI-native CMS using Gemini + Claude)</li>
        </ul>
    </div>
</section>

{{-- EDUCATION + LANGUAGES --}}
<section class="cv-section education">
    <div class="cv-two-col">
        <div>
            <h2 class="cv-section-title">Education</h2>
            <div class="cv-edu-item">
                <div>
                    <div class="cv-edu-degree">Industrial Automation & Robotics</div>
                    <div class="cv-edu-school">Cenfim · Caldas da Rainha, Portugal</div>
                </div>
                <span class="cv-edu-year">2026–2028</span>
            </div>
            <div class="cv-edu-item">
                <div>
                    <div class="cv-edu-degree">Advanced Programme in Design Thinking</div>
                    <div class="cv-edu-school">IADE – Faculty of Design and Technology · Lisbon</div>
                </div>
                <span class="cv-edu-year">2022–2023</span>
            </div>
            <div class="cv-edu-item">
                <div>
                    <div class="cv-edu-degree">BSc in Information Technology</div>
                    <div class="cv-edu-school">College of Computing Technology · Dublin, Ireland</div>
                </div>
                <span class="cv-edu-year">2015–2018</span>
            </div>
        </div>
        <div>
            <h2 class="cv-section-title">Languages</h2>
            <div class="cv-lang-item">
                <span>Portuguese</span>
                <span class="cv-lang-level">Native</span>
            </div>
            <div class="cv-lang-item">
                <span>English</span>
                <span class="cv-lang-level">C1 — Full Professional</span>
            </div>
            <div class="cv-lang-item">
                <span>Spanish</span>
                <span class="cv-lang-level">B1 — Working Proficiency</span>
            </div>

            <h2 class="cv-section-title" style="margin-top:1rem">Recognition</h2>
            <div style="font-size:0.78rem; line-height:1.6; color: var(--color-text-muted, #555)">
                <div>🥇 1st Place — Startup Weekend Limerick</div>
                <div style="font-size:0.72rem">Google for Entrepreneurs · Ireland · 2015</div>
                <div style="margin-top:0.4rem">🥈 2nd Place — Startup Weekend Utrecht</div>
                <div style="font-size:0.72rem">Google for Entrepreneurs · Netherlands · 2017</div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
