<div class="fi-ta-cell-content flex items-center gap-3 py-5 w-fit">
    <img
        src="{{ $getState()['image'] }}"
        alt="{{ $getState()['name'] }}"
        class="w-11 aspect-square rounded-full object-cover ring-2 ring-white dark:ring-gray-900"
    />
    <span class="text-base font-medium text-gray-800 dark:text-white">
        {{ $getState()['name'] }}
    </span>
</div>
