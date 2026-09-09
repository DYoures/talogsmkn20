/**
 * TALOG20 — Shared Element Page Transition
 * ==========================================================================
 * Replaces the old orange voxel-mosaic curtain (page-transition.js).
 *
 * This is a full-document (Blade / MPA) navigation system, so "shared
 * element" continuity is implemented with the browser's native
 * cross-document View Transition API: the destination route loads through
 * completely normal browser navigation (no fetch-and-hold hacks), and the
 * browser itself morphs matching elements between the old and new page.
 *
 * ARCHITECTURE
 * ------------
 * Any element that should participate in a shared-element morph — on
 * either the source or destination page — gets a stable identifier:
 *
 *   <a href="..." data-shared-id="jurusan-3">...</a>          (source)
 *   <div data-shared-id="jurusan-3">...</div>                  (destination)
 *
 * When a link wrapping/containing a `data-shared-id` element is clicked:
 *   1. We remember that id in sessionStorage.
 *   2. We tag the source element with a shared `view-transition-name`
 *      right before the browser captures the old page's snapshot.
 *   3. On the destination page, we look up the element with the matching
 *      `data-shared-id` and tag it with the SAME `view-transition-name`
 *      before the browser captures the new page's snapshot.
 *   4. The browser morphs position/size/border-radius between the two
 *      automatically (see shared-element-transition.css for timing).
 *
 * If no destination element is found (or nothing was tagged at all), we
 * simply don't assign a name — the CSS root cross-fade defined in
 * shared-element-transition.css becomes the fallback, which satisfies the
 * "no matching shared element" failsafe without any extra code.
 *
 * For browsers without cross-document View Transition support (Firefox,
 * as of 2026), a separate, much simpler fallback runs instead: a short
 * fade + slight rise on navigation. Never the old orange overlay.
 */
(() => {
    'use strict';

    const SHARED_ID_KEY = 'talog_shared_element_id';
    const FALLBACK_PENDING_KEY = 'talog_fallback_pending';
    const SHARED_NAME = 'talog-shared-element';
    const FALLBACK_LEAVE_MS = 200;

    const supportsCrossDocViewTransitions = 'onpageswap' in window && 'onpagereveal' in window;

    const prefersReducedMotion = () =>
        window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function safeSessionGet(key) {
        try { return sessionStorage.getItem(key); } catch { return null; }
    }
    function safeSessionSet(key, value) {
        try { sessionStorage.setItem(key, value); } catch { /* ignore */ }
    }
    function safeSessionRemove(key) {
        try { sessionStorage.removeItem(key); } catch { /* ignore */ }
    }

    function findSharedElement(id) {
        if (!id || !window.CSS?.escape) return null;
        try {
            return document.querySelector(`[data-shared-id="${CSS.escape(id)}"]`);
        } catch {
            return null;
        }
    }

    function clearSharedName(el) {
        if (el) el.style.removeProperty('view-transition-name');
    }

    /**
     * Determines whether a click on `link` should participate in our
     * transition system: same-origin, not a new tab/download/anchor/etc.
     */
    function resolveTransitionTarget(link, event) {
        if (!link) return null;
        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') ||
            href.startsWith('javascript:') || link.target === '_blank' || link.hasAttribute('download') ||
            link.hasAttribute('data-no-transition') ||
            event?.ctrlKey || event?.shiftKey || event?.metaKey || event?.altKey || event?.button === 1) {
            return null;
        }

        try {
            const url = new URL(href, window.location.href);
            if (url.origin !== window.location.origin || url.href === window.location.href) return null;
            return url;
        } catch {
            return null;
        }
    }

    function findSharedSource(link) {
        return link.closest('[data-shared-id]') || link.querySelector('[data-shared-id]');
    }

    /**
     * Public, programmatic navigation entry point — used by non-link-based
     * triggers elsewhere in the app (e.g. the interactive 3D book's "back
     * to beranda" cinematic action in education-book.js / futuristic-3d.js).
     * There's no obvious shared element for those call sites, so this just
     * performs a real, transition-eligible navigation; the CSS root
     * cross-fade (native) or fade/rise (fallback) applies automatically.
     */
    function navigate(href) {
        if (!href) return;
        const url = new URL(href, window.location.href);
        if (url.origin !== window.location.origin) {
            window.location.assign(url.href);
            return;
        }

        if (supportsCrossDocViewTransitions || prefersReducedMotion()) {
            window.location.assign(url.href);
            return;
        }

        safeSessionSet(FALLBACK_PENDING_KEY, '1');
        document.documentElement.classList.add('talog-nav-leaving');
        window.setTimeout(() => window.location.assign(url.href), FALLBACK_LEAVE_MS);
    }

    /* ----------------------------------------------------------------
     * Native path — real navigation, browser-driven morph.
     * -------------------------------------------------------------- */
    function initNativeTransitions() {
        document.addEventListener('click', (event) => {
            const link = event.target.closest('a');
            const url = resolveTransitionTarget(link, event);
            if (!url) return;

            const sourceEl = findSharedSource(link);
            if (sourceEl && sourceEl.dataset.sharedId) {
                safeSessionSet(SHARED_ID_KEY, sourceEl.dataset.sharedId);
                sourceEl.style.viewTransitionName = SHARED_NAME;
            } else {
                safeSessionRemove(SHARED_ID_KEY);
            }
            // No preventDefault — this is a real navigation. The destination
            // route starts loading immediately; @view-transition{navigation:auto}
            // in CSS takes over from here.
        }, true);

        // Outgoing document: right before the old page's snapshot is taken.
        window.addEventListener('pageswap', (event) => {
            if (!event.viewTransition) return; // this navigation isn't doing a transition
            event.viewTransition.finished.finally(() => {
                document.querySelectorAll('[data-shared-id]').forEach(clearSharedName);
            });
        });

        // Incoming document: right before the new page's snapshot is taken.
        window.addEventListener('pagereveal', (event) => {
            const sharedId = safeSessionGet(SHARED_ID_KEY);
            safeSessionRemove(SHARED_ID_KEY);
            if (!event.viewTransition || !sharedId) return;

            const destinationEl = findSharedElement(sharedId);
            if (!destinationEl) return; // no meaningful match — root cross-fade applies instead

            destinationEl.style.viewTransitionName = SHARED_NAME;
            event.viewTransition.finished.finally(() => clearSharedName(destinationEl));
        });

        // Browser back/forward restoring a bfcache page: make sure nothing
        // is left in a stale tagged state.
        window.addEventListener('pageshow', (event) => {
            if (event.persisted) {
                document.querySelectorAll('[data-shared-id]').forEach(clearSharedName);
            }
        });
    }

    /* ----------------------------------------------------------------
     * Fallback path — browsers without cross-document View Transitions.
     * A short fade + slight rise. Never the old orange curtain.
     * -------------------------------------------------------------- */
    function initFallbackTransitions() {
        let leaving = false;

        function revealIfPending() {
            if (!document.documentElement.classList.contains('talog-nav-entering')) return;
            document.documentElement.classList.remove('talog-nav-entering');
            if (prefersReducedMotion()) return;
            document.body.classList.add('talog-reveal');
            document.body.addEventListener('animationend', () => {
                document.body.classList.remove('talog-reveal');
            }, { once: true });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', revealIfPending, { once: true });
        } else {
            revealIfPending();
        }

        document.addEventListener('click', (event) => {
            const link = event.target.closest('a');
            const url = resolveTransitionTarget(link, event);
            if (!url || leaving) return;

            if (prefersReducedMotion()) return; // let the browser navigate instantly, untouched

            event.preventDefault();
            leaving = true;
            safeSessionSet(FALLBACK_PENDING_KEY, '1');
            document.documentElement.classList.add('talog-nav-leaving');

            window.setTimeout(() => window.location.assign(url.href), FALLBACK_LEAVE_MS);
        });

        // Restored from bfcache — reset transient state.
        window.addEventListener('pageshow', (event) => {
            if (event.persisted) {
                leaving = false;
                safeSessionRemove(FALLBACK_PENDING_KEY);
                document.documentElement.classList.remove('talog-nav-leaving', 'talog-nav-entering');
                document.body.classList.remove('talog-reveal');
            }
        });

        // Safety net: never leave the page permanently hidden if navigation
        // is interrupted (e.g. user cancels, or the destination fails).
        window.addEventListener('pagehide', () => {
            safeSessionRemove(FALLBACK_PENDING_KEY);
        });
    }

    function init() {
        window.TalogPageTransition = { navigate };
        if (supportsCrossDocViewTransitions) {
            initNativeTransitions();
        } else {
            initFallbackTransitions();
        }
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init, { once: true });
    else init();
})();
