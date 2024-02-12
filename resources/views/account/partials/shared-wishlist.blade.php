<a v-if="wishlist.shared" :href="'{{ route('wishlist.shared', '') }}/' + wishlist.sharing_token" class="text-ct-inactive text-sm hover:underline">
    (@lang('shared'))
</a>