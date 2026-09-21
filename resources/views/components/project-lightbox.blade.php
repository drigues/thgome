@props(['alt' => ''])

{{-- Lightbox — navega dentro da galeria/bloco (estado gerido por projectLightbox()) --}}
<div x-show="isOpen" x-transition x-ref="dialog" tabindex="-1"
     role="dialog" aria-modal="true" aria-label="Galeria de imagens"
     class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4 focus:outline-none"
     @click.self="close()"
     @keydown.escape.window="close()"
     @keydown.left.window="isOpen && prev()"
     @keydown.right.window="isOpen && next()"
     @touchstart.passive="onTouchStart($event)"
     @touchend.passive="onTouchEnd($event)">

    <button type="button" @click="close()" aria-label="Fechar galeria"
            class="absolute top-6 right-6 text-white/70 hover:text-white text-3xl leading-none">✕</button>

    <button type="button" x-show="images.length > 1" @click="prev()" aria-label="Imagem anterior"
            class="absolute left-3 md:left-6 top-1/2 -translate-y-1/2 text-white/70 hover:text-white text-4xl leading-none px-2 py-4">‹</button>

    <img x-ref="image" :src="current" alt="{{ $alt }}"
         class="max-h-[90vh] max-w-[90vw] object-contain rounded-xl">

    <button type="button" x-show="images.length > 1" @click="next()" aria-label="Imagem seguinte"
            class="absolute right-3 md:right-6 top-1/2 -translate-y-1/2 text-white/70 hover:text-white text-4xl leading-none px-2 py-4">›</button>
</div>
