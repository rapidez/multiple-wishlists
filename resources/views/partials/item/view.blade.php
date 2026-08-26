<a
    v-if="findItem(wishlist, {{ $productId }})"
    class="text-base text-ct-accent mb-1 -mt-0.5 hover:underline"
    :href="'{{ route('wishlist.listing') }}/' + wishlist.id"
>
    @lang('View')
</a>
