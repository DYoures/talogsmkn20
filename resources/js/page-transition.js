import gsap from 'gsap';

/**
 * TALOG20 — Voxel Mosaic Page Transition.
 * A five-column, ten-row geometric curtain for Laravel full-document navigation.
 */
(() => {
    'use strict';

    const HELD_KEY = 'talog_voxel_transition_held';
    const HOLD_STARTED_KEY = 'talog_voxel_transition_hold_started';
    const MIN_HOLD_MS = 200;
    const COVER_DURATION = 0.42;
    const REVEAL_DURATION = 0.54;
    const COVER_COLUMN_OFFSETS = [0.030, 0.000, 0.052, 0.014, 0.066];
    const REVEAL_COLUMN_OFFSETS = [0.018, 0.062, 0.000, 0.044, 0.026];

    let overlay;
    let tiles = [];
    let state = 'idle';
    let navigationStarted = false;

    const wait = (milliseconds) => new Promise((resolve) => window.setTimeout(resolve, milliseconds));

    function getTileDelay(tile, columnOffsets, rowStep) {
        const rowFromBottom = 9 - Number(tile.dataset.row);
        return rowFromBottom * rowStep + columnOffsets[Number(tile.dataset.column)];
    }

    function setState(nextState) {
        state = nextState;
        overlay.dataset.transitionState = nextState;
    }

    function showHoldingCurtain() {
        overlay.classList.remove('is-covering', 'is-revealing');
        overlay.classList.add('is-holding');
        setState('phase-2-holding');
        gsap.set(tiles, { scaleY: 1, transformOrigin: '50% 100%' });
    }

    function clearHeldSignal() {
        sessionStorage.removeItem(HELD_KEY);
        sessionStorage.removeItem(HOLD_STARTED_KEY);
        document.documentElement.classList.remove('talog-transition-held');
    }

    function resetOverlay() {
        gsap.killTweensOf(tiles);
        overlay.classList.remove('is-covering', 'is-holding', 'is-revealing');
        overlay.removeAttribute('data-transition-state');
        gsap.set(tiles, { clearProps: 'transform,transformOrigin' });
        state = 'idle';
        navigationStarted = false;
    }

    function tweenTo(vars) {
        return new Promise((resolve) => gsap.to(tiles, { ...vars, onComplete: resolve }));
    }

    async function revealDestination() {
        if (state === 'phase-3-revealing' || state === 'idle') return;

        overlay.classList.remove('is-holding');
        overlay.classList.add('is-revealing');
        setState('phase-3-revealing');
        clearHeldSignal();

        await tweenTo({
            scaleY: 0,
            transformOrigin: '50% 0%',
            duration: REVEAL_DURATION,
            ease: 'power4.inOut',
            stagger: (index, tile) => getTileDelay(tile, REVEAL_COLUMN_OFFSETS, 0.017),
        });

        resetOverlay();
    }

    async function waitForDestinationReadiness() {
        if (document.readyState !== 'complete') {
            await new Promise((resolve) => window.addEventListener('load', resolve, { once: true }));
        }
        if (document.fonts?.ready) await document.fonts.ready;
        await new Promise((resolve) => requestAnimationFrame(() => requestAnimationFrame(resolve)));
    }

    async function revealWhenDestinationIsReady() {
        showHoldingCurtain();
        const holdStartedAt = Number(sessionStorage.getItem(HOLD_STARTED_KEY) || Date.now());
        await waitForDestinationReadiness();
        await wait(Math.max(0, MIN_HOLD_MS - (Date.now() - holdStartedAt)));
        await revealDestination();
    }

    function isStatefulRedirect(url) {
        return url.pathname.startsWith('/theme/switch/') ||
            url.pathname.startsWith('/education/beranda') || url.pathname.startsWith('/futuristic/beranda');
    }

    function prefetch(url) {
        // These GET endpoints deliberately mutate the theme session, so hover
        // prefetching them would cause an unintended theme switch.
        if (url.origin !== window.location.origin || url.pathname === window.location.pathname || isStatefulRedirect(url)) return;
        if ([...document.head.querySelectorAll('link[rel="prefetch"]')].some((link) => link.href === url.href)) return;

        const hint = document.createElement('link');
        hint.rel = 'prefetch';
        hint.as = 'document';
        hint.href = url.href;
        document.head.appendChild(hint);
    }

    async function preloadDestination(url) {
        if (isStatefulRedirect(url)) return;

        const response = await fetch(url.href, {
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'TALOG20-Transition-Preload' },
        });

        if (!response.ok) throw new Error(`Destination returned HTTP ${response.status}`);
        await response.text();
    }

    function canTransitionLink(link, event) {
        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') ||
            href.startsWith('javascript:') || link.target === '_blank' || link.hasAttribute('download') ||
            link.hasAttribute('data-no-transition') || event?.ctrlKey || event?.shiftKey || event?.metaKey || event?.altKey) return null;

        try {
            const url = new URL(href, window.location.href);
            if (url.origin !== window.location.origin || url.href === window.location.href ||
                (url.pathname === window.location.pathname && url.search === window.location.search && url.hash)) return null;
            return url;
        } catch {
            return null;
        }
    }

    async function navigate(href) {
        if (!overlay || navigationStarted || state !== 'idle') return;
        const target = new URL(href, window.location.href);
        if (target.origin !== window.location.origin) return window.location.assign(target.href);

        navigationStarted = true;
        setState('phase-1-covering');
        overlay.classList.remove('is-holding', 'is-revealing');
        overlay.classList.add('is-covering');
        prefetch(target);
        const destinationLoad = preloadDestination(target);
        gsap.set(tiles, { scaleY: 0, transformOrigin: '50% 100%' });

        try {
            await tweenTo({
                scaleY: 1,
                transformOrigin: '50% 100%',
                duration: COVER_DURATION,
                ease: 'power4.inOut',
                stagger: (index, tile) => getTileDelay(tile, COVER_COLUMN_OFFSETS, 0.015),
            });
            showHoldingCurtain();
            sessionStorage.setItem(HELD_KEY, '1');
            sessionStorage.setItem(HOLD_STARTED_KEY, String(Date.now()));
            await destinationLoad;
            window.location.assign(target.href);
        } catch {
            clearHeldSignal();
            await wait(MIN_HOLD_MS);
            await revealDestination();
        }
    }

    function init() {
        overlay = document.getElementById('global-transition-overlay');
        if (!overlay) return;
        tiles = [...overlay.querySelectorAll('.voxel-tile')];
        if (tiles.length !== 50) return;

        window.TalogPageTransition = { navigate };
        if (sessionStorage.getItem(HELD_KEY) || document.documentElement.classList.contains('talog-transition-held')) revealWhenDestinationIsReady();

        document.addEventListener('pointerover', (event) => {
            const link = event.target.closest('a');
            const target = link && canTransitionLink(link);
            if (target) prefetch(target);
        }, { passive: true });

        document.addEventListener('click', (event) => {
            const link = event.target.closest('a');
            const target = link && canTransitionLink(link, event);
            if (!target) return;
            event.preventDefault();
            navigate(target.href);
        });

        window.addEventListener('pageshow', (event) => {
            if (event.persisted && state !== 'idle') {
                clearHeldSignal();
                resetOverlay();
            }
        });
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init, { once: true });
    else init();
})();
