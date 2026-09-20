@props([
    'title',
    'value',
    'description' => null,
    'href' => null,
    'accent' => 'gray', // 'indigo', 'cyan', 'emerald', 'amber', 'gray'
])

@php
    $colorMap = [
        'indigo' => [
            'iconBg' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300',
            'borderHover' => 'hover:border-indigo-400 dark:hover:border-indigo-600',
            'badge' => 'text-indigo-700 dark:text-indigo-400',
        ],
        'cyan' => [
            'iconBg' => 'bg-cyan-50 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-300',
            'borderHover' => 'hover:border-cyan-400 dark:hover:border-cyan-600',
            'badge' => 'text-cyan-700 dark:text-cyan-400',
        ],
        'emerald' => [
            'iconBg' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300',
            'borderHover' => 'hover:border-emerald-400 dark:hover:border-emerald-600',
            'badge' => 'text-emerald-700 dark:text-emerald-400',
        ],
        'amber' => [
            'iconBg' => 'bg-amber-50 text-amber-700 dark:bg-amber-950 dark:text-amber-300',
            'borderHover' => 'hover:border-amber-400 dark:hover:border-amber-600',
            'badge' => 'text-amber-700 dark:text-amber-400',
        ],
        'gray' => [
            'iconBg' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
            'borderHover' => 'hover:border-gray-400 dark:hover:border-gray-600',
            'badge' => 'text-gray-700 dark:text-gray-400',
        ],
    ][$accent] ?? [
        'iconBg' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
        'borderHover' => 'hover:border-gray-400 dark:hover:border-gray-600',
        'badge' => 'text-gray-700 dark:text-gray-400',
    ];

    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    class="relative block p-5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 shadow-xs transition-colors duration-150 {{ $href ? 'cursor-pointer ' . $colorMap['borderHover'] . ' hover:bg-gray-50/70 dark:hover:bg-gray-800/40' : '' }}">
    <div class="flex items-center justify-between gap-4">
        <div class="min-w-0">
            <p class="text-xs font-medium text-gray-600 dark:text-gray-400 truncate uppercase tracking-wider">
                {{ $title }}
            </p>
            <p class="mt-1.5 text-2xl sm:text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ $value }}
            </p>
            @if($description)
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 truncate">
                    {{ $description }}
                </p>
            @endif
        </div>

        @if(isset($icon))
            <div class="w-11 h-11 rounded-lg {{ $colorMap['iconBg'] }} flex items-center justify-center shrink-0">
                {{ $icon }}
            </div>
        @endif
    </div>

    @if($href)
        <div class="mt-3 pt-2.5 border-t border-gray-100 dark:border-gray-800/80 flex items-center justify-between text-xs font-medium {{ $colorMap['badge'] }}">
            <span>Lihat detail</span>
            <svg class="w-3.5 h-3.5 transition-transform duration-150 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </div>
    @endif
</{{ $tag }}>
