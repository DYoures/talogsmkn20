<script>
    if (sessionStorage.getItem('talog_transition_held')) {
        document.documentElement.classList.add('talog-transition-held');
    }
</script>
<style>
    /* Critical held state: masks the destination before the Vite bundle is ready. */
    html.talog-transition-held,
    html.talog-transition-held body { background: #f25f22 !important; }
    html.talog-transition-held #global-transition-overlay {
        visibility: visible !important;
        pointer-events: all !important;
        background: #f25f22 !important;
    }
    html.talog-transition-held .voxel-tile {
        transform: scaleY(1) !important;
        transform-origin: 50% 100% !important;
    }
</style>
