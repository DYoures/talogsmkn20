@props([
    'title' => 'Belum ada data',
    'description' => 'Tidak ada item yang ditemukan saat ini.',
])

<div class="py-12 px-4 text-center">
    <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 flex items-center justify-center mx-auto mb-3.5">
        @if(isset($icon))
            {{ $icon }}
        @else
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
        @endif
    </div>
    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
        {{ $title }}
    </h3>
    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 max-w-sm mx-auto">
        {{ $description }}
    </p>

    @if(isset($action))
        <div class="mt-5">
            {{ $action }}
        </div>
    @endif
</div>
