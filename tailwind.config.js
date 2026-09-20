import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
                display: ['Plus Jakarta Sans', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Education Theme — Academic Prestige Palette
                edu: {
                    navy:    '#0F2B5C',
                    'navy-dark': '#091E42',
                    'navy-light': '#1A3D7C',
                    gold:    '#F2B705',
                    'gold-dark': '#D99E00',
                    'gold-light': '#FFF6D6',
                    'gold-text': '#8A6100',
                    'gold-contrast': '#0B1F4B',
                    canvas:  '#F8FAFC',
                    'canvas-alt': '#F1F5F9',
                    surface: '#FFFFFF',
                    border:  '#E2E8F0',
                    'border-dark': '#CBD5E1',
                    heading: '#0F172A',
                    body:    '#334155',
                    muted:   '#64748B',
                    'accent-gold': '#F2B705',
                },
            },
            boxShadow: {
                'edu-sm': '0 1px 3px 0 rgba(15,43,92,0.08), 0 1px 2px 0 rgba(15,43,92,0.04)',
                'edu': '0 4px 16px 0 rgba(15,43,92,0.10), 0 2px 4px 0 rgba(15,43,92,0.06)',
                'edu-lg': '0 10px 40px 0 rgba(15,43,92,0.14), 0 4px 12px 0 rgba(15,43,92,0.08)',
                'edu-gold': '0 4px 16px 0 rgba(15,43,92,0.10)',
            },
            backgroundImage: {
                'edu-hero': 'linear-gradient(135deg, #0F2B5C 0%, #1A3D7C 50%, #0F2B5C 100%)',
                'edu-card': 'linear-gradient(145deg, #FFFFFF 0%, #F8FAFC 100%)',
                'edu-gold-glow': 'radial-gradient(ellipse at center, rgba(242,183,5,0.15) 0%, transparent 70%)',
            },
            animation: {
                'fade-in': 'fadeIn 0.6s ease-out forwards',
                'slide-up': 'slideUp 0.5s ease-out forwards',
                'float': 'float 3s ease-in-out infinite',
                'pulse-glow': 'pulseGlow 2s ease-in-out infinite',
            },
            keyframes: {
                fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                slideUp: { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                float: { '0%,100%': { transform: 'translateY(0px)' }, '50%': { transform: 'translateY(-8px)' } },
                pulseGlow: { '0%,100%': { boxShadow: '0 0 0 0 rgba(242,183,5,0.3)' }, '50%': { boxShadow: '0 0 0 8px rgba(242,183,5,0)' } },
            },
        },
    },

    plugins: [forms],
};
