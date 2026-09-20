<div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-xs">
    <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200 dark:divide-gray-800 text-left text-sm']) }}>
        @if(isset($header))
            <thead class="bg-gray-50 dark:bg-gray-800 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                {{ $header }}
            </thead>
        @endif
        <tbody class="divide-y divide-gray-200 dark:divide-gray-800 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            {{ $slot }}
        </tbody>
    </table>
</div>
