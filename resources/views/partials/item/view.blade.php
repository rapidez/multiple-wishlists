<a
    v-if="findItem(wishlist, {{ $productId }})"
    class="text-base text-primary mb-1 -mt-0.5 hover:underline"
    :href="'{{ route('wishlist.show', '') }}/' + wishlist.id"
>
    @lang('View')
</a>