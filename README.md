# thgo.me — Personal Portfolio

Personal portfolio of **Thiago Rodrigues**, Product Designer with 10+ years of experience.

**Live site:** [thgo.me](https://thgo.me)

---

## About this project

This repository is the source code of my personal portfolio — built from scratch as a full-stack project. I made it public so recruiters, collaborators, and fellow designers can see not just the final result, but the process behind it.

Design and development are not separate disciplines in my workflow. This codebase reflects that.

---

## Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 11 |
| Admin panel | Filament 3 |
| Media | Spatie MediaLibrary |
| Frontend | Tailwind CSS + Alpine.js |
| Animations | GSAP + Splitting.js |
| Database | MySQL (production) / SQLite (local) |
| Deploy | Laravel Forge → Hetzner (Helsinki) |

---

## Structure

```
app/
├── Filament/Resources/   # Admin panel — projects, categories, services, media
├── Http/Controllers/     # Public portfolio routes
└── Models/               # Project, Category, Service, SiteMedia, Setting...

resources/views/
├── home.blade.php        # Homepage with featured cases
├── project.blade.php     # Case study page
├── about.blade.php       # About + experience timeline
├── work.blade.php        # All projects with category filters
└── cv.blade.php          # Printable CV page (/cv)
```

---

## Why build it instead of using a template

I work daily with designers who use Framer, Webflow, or Squarespace. Nothing wrong with that. But I wanted to demonstrate what I actually do: design decisions grounded in technical reality.

Building my own portfolio means:
- Every animation, spacing, and interaction was a deliberate choice
- I handled the deployment pipeline, storage, DNS, and SSL myself
- The admin panel lets me update case studies without touching code
- The `/cv` route generates a print-ready PDF from the same design system

---

## Features

- **Case studies** with dual-description layout, image blocks with configurable layouts, pitch video per project, and inline image support in the editor
- **Responsive cover images** — 4:3 on mobile, 16:9 on desktop
- **Light / dark mode** toggle with localStorage persistence
- **Printable CV** at `/cv` — same visual language, print-optimised for 2 A4 pages
- **Admin panel** at `/admin` — full content management via Filament
- **Zero-downtime deploys** via Laravel Forge with persistent shared storage

---

## Notes

This repository is public for transparency, not as a starter template. The codebase is specific to my content, design system, and infrastructure setup.

If you're a recruiter or collaborator viewing this — the portfolio itself is the better place to start: [thgo.me](https://thgo.me)

---

*Thiago Rodrigues · Product Designer · [thgo.me](https://thgo.me) · [linkedin.com/in/thgorodrigues](https://linkedin.com/in/thgorodrigues)*
