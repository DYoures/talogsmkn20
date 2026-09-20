@props([
    'title',
    'description' => null,
    'backUrl' => null,
])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 pb-4 border-b border-gray-200 dark:border-gray-800">
    <div class="min-w-0">
        @if($backUrl)
            <div class="mb-2">
                <a href="{{ $backUrl }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors duration-150">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>
        @endif
        <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            {{ $title }}
        </h2>
        @if($description)
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ $description }}
            </p>
        @endif
    </div>

    @if(isset($actions) && $actions->isNotEmpty())
        <div class="flex items-center gap-2.5 shrink-0">
            {{ $actions }}
        </div>
    @endif
</div>
