# thgo-portfolio

Stack: Laravel 12 · Filament 3 · Spatie MediaLibrary · Tailwind · Alpine.js · GSAP · Lenis

## Setup local
1. `cp .env.example .env && php artisan key:generate`
2. Edita `.env` com as tuas credenciais de base de dados
3. `php artisan migrate:fresh --seed`
4. `php artisan storage:link`
5. `npm install && npm run dev`
6. `php artisan serve`

Admin: http://localhost:8000/admin
Login: admin@thgo.me / password

## Deploy (Forge + Hetzner)
Ver `.claude/references/deploy-forge.md`
