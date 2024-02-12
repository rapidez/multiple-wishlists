<a class="flex items-center gap-x-7 bg-white rounded border pb-5 pt-4 px-7 hover:opacity-75" :href="'{{ route('wishlist.show', '') }}/'+wishlist.id">
    <x-heroicon-s-heart class="w-5 h-5 text-ct-wishlist" />
    <div class="flex flex-col">
        <div class="w-full text-base font-medium text-ct-neutral">@lang('Number of articles') (@{{ wishlist.items.length }})</div>
        <div class="w-full text-sm truncate text-ct-inactive">@{{ wishlist.description }}</div>
    </div>
</a>