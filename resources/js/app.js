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

window.toggleTheme = function() {
    const html = document.documentElement;
    const isLight = html.classList.toggle('light');
    localStorage.setItem('theme', isLight ? 'light' : 'dark');

    document.getElementById('theme-icon-dark').classList.toggle('hidden', isLight);
    document.getElementById('theme-icon-light').classList.toggle('hidden', !isLight);
}

document.addEventListener('DOMContentLoaded', () => {
    const isLight = document.documentElement.classList.contains('light');
    const iconDark = document.getElementById('theme-icon-dark');
    const iconLight = document.getElementById('theme-icon-light');
    if (iconDark && iconLight) {
        iconDark.classList.toggle('hidden', isLight);
        iconLight.classList.toggle('hidden', !isLight);
    }
});

Alpine.start();
