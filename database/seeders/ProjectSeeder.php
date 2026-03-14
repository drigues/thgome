<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Thr33',
                'excerpt' => 'Full-stack digital product — brand, design system, and web platform built from zero to launch.',
                'client' => 'Thr33 Studio',
                'year' => '2024',
                'url' => 'https://99web.pt',
                'category' => '0→1 Products',
                'sort_order' => 1,
                'is_featured' => true,
                'is_active' => true,
                'cover_url' => 'https://images.pexels.com/photos/3182812/pexels-photo-3182812.jpeg',
                'description' => <<<'HTML'
<h2>Overview</h2>
<p>Thr33 is a full-stack digital studio project — brand identity, design system, and web platform built from zero to launch. The goal was to create a premium digital presence that reflects the studio's philosophy: design with engineering precision.</p>

<h3>The Challenge</h3>
<p>Starting from scratch with no existing brand, we needed to create a cohesive digital identity that communicates technical expertise while remaining approachable. The platform needed to serve as both portfolio and lead-generation tool.</p>

<h3>Process</h3>
<ul>
    <li>Brand strategy and visual identity development</li>
    <li>Design system with tokens, components, and documentation</li>
    <li>High-fidelity prototyping in Figma</li>
    <li>Full-stack development with Laravel and Tailwind CSS</li>
    <li>Performance optimization and SEO implementation</li>
</ul>

<h3>Design System</h3>
<p>Built a comprehensive design system from the ground up — colour palette, typography scale, spacing tokens, and a component library that ensures consistency across all touchpoints.</p>

<h3>Results</h3>
<ul>
    <li>95+ Lighthouse performance score</li>
    <li>Sub-2s page load time</li>
    <li>40% increase in qualified leads within the first quarter</li>
    <li>Design system adopted across 3 internal projects</li>
</ul>

<blockquote>
    <p>"Building the brand and product simultaneously allowed us to maintain perfect alignment between design intent and engineering execution."</p>
</blockquote>

<h3>Key Takeaways</h3>
<p>This project reinforced the value of owning both design and development. By controlling the full stack, we eliminated the typical friction between design handoff and implementation, resulting in a pixel-perfect product delivered ahead of schedule.</p>
HTML,
            ],
            [
                'title' => 'McKesson',
                'excerpt' => 'Redesigning clinical workflows for 75,000+ users across North America\'s largest healthcare distributor.',
                'client' => 'McKesson Corporation',
                'year' => '2025',
                'url' => null,
                'category' => 'Enterprise UX',
                'sort_order' => 2,
                'is_featured' => true,
                'is_active' => true,
                'cover_url' => 'https://images.pexels.com/photos/3184465/pexels-photo-3184465.jpeg',
                'description' => <<<'HTML'
<h2>Overview</h2>
<p>McKesson is North America's largest pharmaceutical distributor. I joined as Product Designer to redesign critical clinical workflows used by 75,000+ healthcare professionals across the continent.</p>

<h3>The Challenge</h3>
<p>Legacy enterprise systems with decades of accumulated complexity. Users reported high error rates, slow task completion, and frequent workarounds. The existing interface hadn't been meaningfully updated in years, creating significant usability debt.</p>

<h3>Research</h3>
<ul>
    <li>Conducted 30+ user interviews across 5 distinct user roles</li>
    <li>Shadowed pharmacists and clinical staff in real-world environments</li>
    <li>Mapped 12 critical user journeys and identified 47 pain points</li>
    <li>Analysed support ticket data to quantify impact of UX issues</li>
</ul>

<h3>Design Approach</h3>
<p>Rather than a complete redesign (which the business couldn't afford), I developed a progressive enhancement strategy — improving the most impactful workflows first while establishing a design system that would unify the platform over time.</p>

<h4>Key Design Decisions</h4>
<ul>
    <li>Task-based navigation replacing feature-based menu structure</li>
    <li>Contextual help system reducing support tickets by 35%</li>
    <li>Accessibility-first approach meeting WCAG 2.1 AA across all workflows</li>
    <li>Real-time validation preventing data entry errors at source</li>
</ul>

<h3>Results</h3>
<ul>
    <li>28% reduction in average task completion time</li>
    <li>35% decrease in support tickets for redesigned workflows</li>
    <li>92% user satisfaction score (up from 64%)</li>
    <li>Zero critical accessibility issues in audit</li>
</ul>

<blockquote>
    <p>"The progressive approach let us deliver measurable value every sprint while building toward a unified platform vision."</p>
</blockquote>
HTML,
            ],
            [
                'title' => 'BladeInsight',
                'excerpt' => 'Design system and IoT platform for wind energy — from component library to production dashboard.',
                'client' => 'BladeInsight',
                'year' => '2023',
                'url' => null,
                'category' => 'Design Systems',
                'sort_order' => 3,
                'is_featured' => true,
                'is_active' => true,
                'cover_url' => 'https://images.pexels.com/photos/1108572/pexels-photo-1108572.jpeg',
                'description' => <<<'HTML'
<h2>Overview</h2>
<p>BladeInsight provides IoT-powered monitoring solutions for the wind energy industry. I led design for their core platform, building a design system from scratch and shipping a production-grade monitoring dashboard.</p>

<h3>The Challenge</h3>
<p>The platform needed to display complex real-time data from thousands of wind turbine sensors in a way that was immediately actionable for field engineers. Information density was critical — operators monitor dozens of turbines simultaneously and need to spot anomalies instantly.</p>

<h3>Design System</h3>
<ul>
    <li>Token-based architecture with design tokens synced to code</li>
    <li>50+ reusable components documented in Storybook</li>
    <li>Dark/light theme support optimised for control room environments</li>
    <li>Data visualisation library with standardised chart patterns</li>
    <li>Responsive grid system for dashboard customisation</li>
</ul>

<h3>Dashboard Design</h3>
<p>The monitoring dashboard was designed around the concept of "glanceability" — operators should be able to assess turbine health status within seconds, not minutes.</p>

<h4>Key Features</h4>
<ul>
    <li>Real-time sensor data with configurable alert thresholds</li>
    <li>Predictive maintenance indicators using ML-driven anomaly detection</li>
    <li>Customisable dashboard layouts for different operator roles</li>
    <li>Offline-capable PWA for field engineers with intermittent connectivity</li>
</ul>

<h3>Results</h3>
<ul>
    <li>Design system adopted across 3 product teams</li>
    <li>60% reduction in UI development time for new features</li>
    <li>Mean time to anomaly detection reduced from 12 minutes to 45 seconds</li>
    <li>Platform handling 2M+ data points per day per wind farm</li>
</ul>

<blockquote>
    <p>"The design system became the foundation for every product decision — it wasn't just a component library, it was a shared language between design and engineering."</p>
</blockquote>
HTML,
            ],
            [
                'title' => 'MindTools',
                'excerpt' => 'Redesigning the core learning experience for 30M+ global users — research, prototyping, and 3 major feature launches.',
                'client' => 'MindTools',
                'year' => '2023',
                'url' => null,
                'category' => 'Product Design',
                'sort_order' => 4,
                'is_featured' => true,
                'is_active' => true,
                'cover_url' => 'https://images.pexels.com/photos/3184338/pexels-photo-3184338.jpeg',
                'description' => <<<'HTML'
<h2>Overview</h2>
<p>MindTools is one of the world's leading learning platforms with 30M+ users globally. I redesigned the core learning experience, led research sprints, and shipped three major features that transformed how users discover and engage with content.</p>

<h3>The Challenge</h3>
<p>Despite massive traffic, engagement metrics were declining. Users found content but didn't complete learning paths. The platform's information architecture had grown organically over 25 years, creating a fragmented experience that made progressive learning nearly impossible.</p>

<h3>Research</h3>
<ul>
    <li>5 research sprints over 6 months with 80+ participants</li>
    <li>Quantitative analysis of 12 months of behavioural data</li>
    <li>Card sorting and tree testing to validate new IA</li>
    <li>A/B testing framework established for continuous validation</li>
</ul>

<h3>Key Features Shipped</h3>
<h4>1. Adaptive Learning Paths</h4>
<p>Personalised content recommendations based on user goals, role, and learning history. Replaced the static category-based navigation with a dynamic, goal-oriented experience.</p>

<h4>2. Progress Dashboard</h4>
<p>A personal learning hub showing progress, streaks, bookmarks, and recommended next steps. Designed to create a sense of momentum and achievement.</p>

<h4>3. Interactive Assessments</h4>
<p>Embedded skill assessments that help users identify knowledge gaps and get targeted content recommendations.</p>

<h3>Results</h3>
<ul>
    <li>34% increase in content completion rate</li>
    <li>22% improvement in return visit frequency</li>
    <li>Net Promoter Score increased from 32 to 51</li>
    <li>3 features shipped on time across 2 quarters</li>
</ul>

<blockquote>
    <p>"The research-led approach gave us confidence to make bold decisions. Every feature shipped had data behind it."</p>
</blockquote>
HTML,
            ],
            [
                'title' => 'Progress Systems',
                'excerpt' => 'Payment processing dashboards, merchant onboarding, and compliance workflows for fintech.',
                'client' => 'Progress Systems',
                'year' => '2019',
                'url' => null,
                'category' => 'Fintech',
                'sort_order' => 5,
                'is_featured' => true,
                'is_active' => true,
                'cover_url' => 'https://images.pexels.com/photos/6801648/pexels-photo-6801648.jpeg',
                'description' => <<<'HTML'
<h2>Overview</h2>
<p>Progress Systems builds payment processing infrastructure for European merchants. I designed the merchant-facing dashboard, onboarding flows, and compliance management tools that process millions of euros in transactions monthly.</p>

<h3>The Challenge</h3>
<p>Fintech products need to balance regulatory complexity with user simplicity. Merchants need to understand their transaction data, manage compliance requirements, and onboard quickly — all while the underlying systems handle PCI-DSS, PSD2, and GDPR requirements.</p>

<h3>Merchant Dashboard</h3>
<ul>
    <li>Real-time transaction monitoring with drill-down analytics</li>
    <li>Settlement tracking and reconciliation tools</li>
    <li>Chargeback management workflow</li>
    <li>Revenue reporting with custom date ranges and export</li>
</ul>

<h3>Onboarding Flow</h3>
<p>Designed a progressive onboarding experience that gets merchants processing payments within 24 hours while collecting all required KYC/KYB documentation.</p>

<h4>Key Decisions</h4>
<ul>
    <li>Multi-step form with clear progress indication and save-and-resume</li>
    <li>Document upload with real-time validation and OCR assistance</li>
    <li>Risk-based verification tiers — low-risk merchants go live faster</li>
    <li>Automated compliance checks with clear status communication</li>
</ul>

<h3>Results</h3>
<ul>
    <li>Merchant onboarding time reduced from 5 days to 24 hours</li>
    <li>68% reduction in onboarding drop-off rate</li>
    <li>Dashboard NPS of 72 (industry average: 45)</li>
    <li>Zero compliance violations during regulatory audit</li>
</ul>

<blockquote>
    <p>"In fintech, good design isn't just about aesthetics — it's about making complex regulatory requirements invisible to the user while keeping the business compliant."</p>
</blockquote>
HTML,
            ],
        ];

        foreach ($projects as $data) {
            $categoryName = $data['category'];
            $coverUrl = $data['cover_url'];
            unset($data['category'], $data['cover_url']);

            $category = Category::where('name', $categoryName)->first();
            $data['category_id'] = $category?->id;

            $project = Project::firstOrCreate(['slug' => \Str::slug($data['title'])], $data);

            try {
                $project->addMediaFromUrl($coverUrl)->toMediaCollection('cover');
            } catch (\Exception $e) {
                logger('Media: ' . $e->getMessage());
            }
        }
    }
}
