<a class="flex items-start gap-x-7 bg-white rounded border pb-5 pt-4 px-7 hover:opacity-75" :href="'{{ route('wishlist.show', '') }}/'+wishlist.id">
    <x-heroicon-s-heart class="w-5 h-5 text-ct-wishlist mt-1.5" />
    <div class="flex flex-col">
        <div class="w-full text-base font-medium text-ct-neutral">@lang('Number of articles') (@{{ wishlist.items.length }})</div>
        <div class="w-full text-sm text-ct-inactive max-w-48 max-md:truncate md:max-w-3xl">@{{ wishlist.description }}</div>
    </div>
</a>