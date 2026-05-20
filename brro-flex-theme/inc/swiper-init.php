<?php
/**
 * Swiper shared init — dedicated file (not global-functions.php).
 *
 * @package Brro_Flex_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Return a shared Swiper init script.
 *
 * - Boots every root with `data-brro-swiper`
 * - Safe to run on pages without sliders
 * - Does not throw when optional UI elements are missing
 *
 * Per-slider attributes (all optional):
 *   data-brro-swiper-loop="true|false"          (default false)
 *   data-brro-swiper-slides="N|auto"            (default 1)
 *   data-brro-swiper-autoh="true|false"         (default true)
 *   data-brro-swiper-speed="600"                (default 600)
 *   data-brro-swiper-space="30"                 (px between slides, default 0)
 *   data-brro-swiper-freemode="true|false"      (default false)
 *   data-brro-swiper-freemode-momentum="true|false" (default true, only when freemode is on)
 *
 * @return string Inline JavaScript for wp_add_inline_script().
 */
function brro_get_swiper_init_script() {
    $script = <<<'JS'
(function () {
    if (typeof Swiper === 'undefined') return;

    function toBool(val, fallback) {
        if (val === undefined || val === null || val === '') return fallback;
        return String(val).toLowerCase() === 'true';
    }

    function toNum(val, fallback) {
        var n = Number(val);
        return Number.isFinite(n) ? n : fallback;
    }

    function parseSlides(val, fallback) {
        if (val === 'auto') return 'auto';
        var n = Number(val);
        return Number.isFinite(n) ? n : fallback;
    }

    function initOne(root) {
        if (!root || root.dataset.brroSwiperInitialized === '1') return;

        var paginationEl = root.querySelector('.swiper-pagination');
        var prevEl = root.querySelector('.swiper-button-prev');
        var nextEl = root.querySelector('.swiper-button-next');

        var options = {
            loop: toBool(root.dataset.brroSwiperLoop, false),
            slidesPerView: parseSlides(root.dataset.brroSwiperSlides, 1),
            autoHeight: toBool(root.dataset.brroSwiperAutoh, true),
            grabCursor: true,
            watchOverflow: true,
            speed: toNum(root.dataset.brroSwiperSpeed, 600),
            spaceBetween: toNum(root.dataset.brroSwiperSpace, 0)
        };

        if (paginationEl) {
            options.pagination = { el: paginationEl, clickable: true };
        }
        if (prevEl && nextEl) {
            options.navigation = { prevEl: prevEl, nextEl: nextEl };
        }

        if (toBool(root.dataset.brroSwiperFreemode, false)) {
            options.freeMode = {
                enabled: true,
                momentum: toBool(root.dataset.brroSwiperFreemodeMomentum, true)
            };
        }

        new Swiper(root, options);
        root.dataset.brroSwiperInitialized = '1';
    }

    function initAll() {
        var roots = document.querySelectorAll('[data-brro-swiper]');
        if (!roots.length) return;
        roots.forEach(initOne);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }
})();
JS;

    return $script;
}
