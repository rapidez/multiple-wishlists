<a class="flex items-center gap-x-7 bg-white rounded border pb-5 pt-4 px-7 hover:opacity-75" :href="'{{ route('wishlist.listing') }}/'+wishlist.id">
    <x-heroicon-s-heart class="size-5 text mt-1.5" />
    <div class="flex flex-col">
        <div class="w-full font-medium text">@lang('Number of articles (:count)', ['count' => '@{{ wishlist.items.length }}'])</div>
        <div class="w-full text-sm text-muted">@lang('Latest update: :date', ['date' => '@{{ wishlist.updated_at.substring(0,10) }}']) </div>
        <div class="w-full text-sm text-muted max-w-48 max-md:truncate md:max-w-3xl">@{{ wishlist.description }}</div>
    </div>
</a>
