<div x-data="modeSwitch"
     @keydown="handleKeydown($event)"
     role="radiogroup"
     aria-label="Pengaturan Mode Tampilan"
     class="relative inline-flex items-center p-0.5 rounded-full bg-gray-200/80 dark:bg-gray-800 border border-gray-300 dark:border-gray-700/80 shadow-inner select-none transition-colors duration-200">

    {{-- Sliding Thumb indicator --}}
    <div class="mode-switch-thumb absolute top-0.5 left-0.5 w-7 h-7 rounded-full bg-white dark:bg-gray-700 shadow-sm transition-transform duration-250 ease-out pointer-events-none motion-reduce:transition-none"
         :style="'transform: ' + thumbTranslate()">
    </div>

    {{-- 1. Light Mode (Matahari / Terang) --}}
    <button type="button"
            x-ref="lightBtn"
            @click="setMode('light')"
            role="radio"
            :aria-checked="mode === 'light'"
            title="Mode Terang"
            aria-label="Mode Terang"
            class="relative z-10 w-7 h-7 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 transition-colors duration-150"
            :class="{ 'text-amber-500 hover:text-amber-600 dark:text-amber-400': mode === 'light' }">
        <svg class="w-3.5 h-3.5 transition-transform duration-200 motion-reduce:transition-none"
             :class="{ 'scale-110 rotate-45 text-amber-500 dark:text-amber-400': mode === 'light' }"
             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
    </button>

    {{-- 2. Auto Mode (Monitor / Otomatis) --}}
    <button type="button"
            x-ref="autoBtn"
            @click="setMode('auto')"
            role="radio"
            :aria-checked="mode === 'auto'"
            title="Mode Otomatis (Ikut Sistem)"
            aria-label="Mode Otomatis"
            class="relative z-10 w-7 h-7 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 transition-colors duration-150"
            :class="{ 'text-indigo-600 dark:text-indigo-400 font-semibold': mode === 'auto' }">
        <svg class="w-3.5 h-3.5 transition-transform duration-200 motion-reduce:transition-none"
             :class="{ 'scale-110 text-indigo-600 dark:text-indigo-400': mode === 'auto' }"
             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
    </button>

    {{-- 3. Dark Mode (Bulan / Gelap) --}}
    <button type="button"
            x-ref="darkBtn"
            @click="setMode('dark')"
            role="radio"
            :aria-checked="mode === 'dark'"
            title="Mode Gelap"
            aria-label="Mode Gelap"
            class="relative z-10 w-7 h-7 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 transition-colors duration-150"
            :class="{ 'text-indigo-600 dark:text-indigo-400': mode === 'dark' }">
        <svg class="w-3.5 h-3.5 transition-transform duration-200 motion-reduce:transition-none"
             :class="{ 'scale-110 -rotate-12 text-indigo-600 dark:text-indigo-400': mode === 'dark' }"
             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
    </button>
</div>
