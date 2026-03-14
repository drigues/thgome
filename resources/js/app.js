import Alpine from 'alpinejs';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from '@studio-freight/lenis';
import Splitting from 'splitting';

gsap.registerPlugin(ScrollTrigger);
window.Alpine = Alpine;
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
window.Splitting = Splitting;

// Lenis smooth scroll
const lenis = new Lenis({
    duration: 1.2,
    easing: t => Math.min(1, 1.001 - Math.pow(2, -10 * t))
});
lenis.on('scroll', ScrollTrigger.update);
gsap.ticker.add(time => lenis.raf(time * 1000));
gsap.ticker.lagSmoothing(0);

// Cursor personalizado
const dot  = document.querySelector('.cursor-dot');
const ring = document.querySelector('.cursor-ring');
if (dot && ring) {
    const moveDot  = gsap.quickTo(dot,  'x', { duration: 0.15, ease: 'power3' });
    const moveDotY = gsap.quickTo(dot,  'y', { duration: 0.15, ease: 'power3' });
    const moveRing  = gsap.quickTo(ring, 'x', { duration: 0.5, ease: 'power3' });
    const moveRingY = gsap.quickTo(ring, 'y', { duration: 0.5, ease: 'power3' });
    window.addEventListener('mousemove', e => {
        moveDot(e.clientX); moveDotY(e.clientY);
        moveRing(e.clientX); moveRingY(e.clientY);
    });
    document.querySelectorAll('a, button').forEach(el => {
        el.addEventListener('mouseenter', () => ring.classList.add('is-hovering'));
        el.addEventListener('mouseleave', () => ring.classList.remove('is-hovering'));
    });
}

// Scroll progress bar
gsap.to('#scroll-progress', {
    scaleX: 1, ease: 'none',
    scrollTrigger: { trigger: document.body, start: 'top top', end: 'bottom bottom', scrub: true }
});

// Animações globais scroll
document.addEventListener('DOMContentLoaded', () => {
    gsap.utils.toArray('[data-animate]').forEach(el => {
        gsap.fromTo(el,
            { y: 60, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.9, ease: 'power3.out',
              scrollTrigger: { trigger: el, start: 'top 88%' } }
        );
    });
});

// Page transitions
document.querySelectorAll('a[href]').forEach(a => {
    if (a.hostname === location.hostname && !a.hasAttribute('target') && !a.href.includes('/admin')) {
        a.addEventListener('click', e => {
            const href = a.href;
            if (!href.includes('#')) {
                e.preventDefault();
                gsap.to('#main-content', {
                    opacity: 0, y: -16, duration: 0.22, ease: 'power2.in',
                    onComplete: () => { window.location.href = href; }
                });
            }
        });
    }
});

Alpine.start();
