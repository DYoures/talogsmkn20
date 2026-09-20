
import Alpine from 'alpinejs';
import './shared-element-transition.js';

window.Alpine = Alpine;

Alpine.data('modeSwitch', function () {
    return {
        mode: 'auto',

        init: function () {
            try {
                var saved = localStorage.getItem('talog-color-mode');
                if (saved === 'light' || saved === 'dark') {
                    this.mode = saved;
                } else {
                    this.mode = 'auto';
                }
            } catch (e) {
                this.mode = 'auto';
            }
            this.applyMode(this.mode, false);

            if (window.matchMedia) {
                var mql = window.matchMedia('(prefers-color-scheme: dark)');
                var self = this;
                var changeHandler = function (e) {
                    if (self.mode === 'auto') {
                        self.applyMode('auto', true);
                    }
                };
                if (mql.addEventListener) {
                    mql.addEventListener('change', changeHandler);
                } else if (mql.addListener) {
                    mql.addListener(changeHandler);
                }
            }
        },

        setMode: function (newMode) {
            if (this.mode === newMode && (newMode === 'light' || newMode === 'dark')) return;
            this.mode = newMode;
            try {
                if (newMode === 'auto') {
                    localStorage.removeItem('talog-color-mode');
                } else {
                    localStorage.setItem('talog-color-mode', newMode);
                }
            } catch (e) { /* noop */ }
            this.applyMode(newMode, true);
        },

        applyMode: function (m, animate) {
            if (typeof animate === 'undefined') animate = false;
            var isDark = false;
            if (m === 'dark') {
                isDark = true;
            } else if (m === 'light') {
                isDark = false;
            } else {
                isDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            }

            var currentIsDark = document.documentElement.classList.contains('dark');
            if (currentIsDark === isDark) return;

            var updateDom = function () {
                if (isDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            };

            var prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (!animate || prefersReduced || typeof document.startViewTransition !== 'function') {
                updateDom();
                return;
            }

            document.documentElement.classList.add('mode-vt');
            try {
                var transition = document.startViewTransition(function () {
                    updateDom();
                });
                transition.finished.finally(function () {
                    document.documentElement.classList.remove('mode-vt');
                });
            } catch (err) {
                updateDom();
                document.documentElement.classList.remove('mode-vt');
            }
        },

        handleKeydown: function (e) {
            var modes = ['light', 'auto', 'dark'];
            var idx = modes.indexOf(this.mode);
            var self = this;
            if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                e.preventDefault();
                var nextMode = modes[(idx + 1) % 3];
                self.setMode(nextMode);
                self.$nextTick(function () {
                    var ref = self.$refs[nextMode + 'Btn'];
                    if (ref) ref.focus();
                });
            } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                e.preventDefault();
                var prevMode = modes[(idx - 1 + 3) % 3];
                self.setMode(prevMode);
                self.$nextTick(function () {
                    var ref = self.$refs[prevMode + 'Btn'];
                    if (ref) ref.focus();
                });
            }
        },

        thumbTranslate: function () {
            if (this.mode === 'light') return 'translateX(0%)';
            if (this.mode === 'auto') return 'translateX(100%)';
            return 'translateX(200%)';
        }
    };
});

Alpine.start();
