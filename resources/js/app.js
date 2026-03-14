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

const lenis = new Lenis({
    duration: 0.8,
    easing: t => 1 - Math.pow(1 - t, 3)
});
lenis.on('scroll', ScrollTrigger.update);
gsap.ticker.add(time => lenis.raf(time * 1000));
gsap.ticker.lagSmoothing(0);

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

Alpine.start();
