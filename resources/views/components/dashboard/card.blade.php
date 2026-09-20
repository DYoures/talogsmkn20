@props([
    'title' => null,
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-xs overflow-hidden']) }}>
    @if($title || isset($action) || $description)
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                @if($title)
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        {{ $title }}
                    </h3>
                @endif
                @if($description)
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">
                        {{ $description }}
                    </p>
                @endif
            </div>

            @if(isset($action))
                <div class="shrink-0">
                    {{ $action }}
                </div>
            @endif
        </div>
    @endif

    <div class="p-5 sm:p-6">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-5 py-3.5 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
            {{ $footer }}
        </div>
    @endif
</div>
