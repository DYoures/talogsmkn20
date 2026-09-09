<script>
    /**
     * TALOG20 — Shared Element Transition (pre-paint bootstrap)
     *
     * The primary transition mechanism is the browser's native
     * cross-document View Transition API (see resources/js/shared-element-transition.js
     * and resources/css/shared-element-transition.css). Browsers that
     * support it (`onpageswap` in window) need nothing here — the
     * `@view-transition` CSS rule handles everything automatically.
     *
     * For browsers WITHOUT support (e.g. Firefox), we run a tiny, subtle
     * fade/rise fallback instead. This inline script only exists to avoid
     * a flash of unstyled content: if the previous page flagged that it is
     * navigating here via the fallback, we hide <body> before first paint
     * so the JS module can reveal it with a soft animation once ready.
     */
    (function () {
        if ('onpageswap' in window) return; // native path — nothing to do
        try {
            if (sessionStorage.getItem('talog_fallback_pending')) {
                sessionStorage.removeItem('talog_fallback_pending');
                document.documentElement.classList.add('talog-nav-entering');
            }
        } catch (e) { /* sessionStorage unavailable — degrade silently */ }
    })();
</script>
