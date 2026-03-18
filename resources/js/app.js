import Alpine from 'alpinejs';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Splitting from 'splitting';

gsap.registerPlugin(ScrollTrigger);
window.Alpine = Alpine;
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
window.Splitting = Splitting;

document.addEventListener('DOMContentLoaded', () => {
    gsap.utils.toArray('[data-animate]').forEach(el => {
        gsap.fromTo(el,
            { y: 40, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.7, ease: 'power3.out',
              scrollTrigger: { trigger: el, start: 'top 88%' } }
        );
    });
});

document.querySelectorAll('a[href]').forEach(a => {
    if (a.hostname === location.hostname && !a.hasAttribute('target') && !a.href.includes('/admin')) {
        a.addEventListener('click', e => {
            const href = a.href;
            if (!href.includes('#')) {
                e.preventDefault();
                gsap.to('#main-content', {
                    opacity: 0, duration: 0.2, ease: 'power2.in',
                    onComplete: () => { window.location.href = href; }
                });
            }
        });
    }
});

window.closeMobileMenu = function() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.add('hidden');
    menu.classList.remove('flex');
    document.body.style.overflow = '';
}

window.addEventListener('menu-toggle', (e) => {
    const menu = document.getElementById('mobile-menu');
    if (e.detail.open) {
        menu.classList.remove('hidden');
        menu.classList.add('flex');
        document.body.style.overflow = 'hidden';
    } else {
        closeMobileMenu();
    }
});

window.toggleTheme = function() {
    const html = document.documentElement;
    const isDark = html.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    ['theme-icon-dark','theme-icon-dark-mobile'].forEach(id => {
        document.getElementById(id)?.classList.toggle('hidden', isDark);
    });
    ['theme-icon-light','theme-icon-light-mobile'].forEach(id => {
        document.getElementById(id)?.classList.toggle('hidden', !isDark);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const isDark = document.documentElement.classList.contains('dark');
    ['theme-icon-dark','theme-icon-dark-mobile'].forEach(id => {
        document.getElementById(id)?.classList.toggle('hidden', isDark);
    });
    ['theme-icon-light','theme-icon-light-mobile'].forEach(id => {
        document.getElementById(id)?.classList.toggle('hidden', !isDark);
    });
});

Alpine.start();
