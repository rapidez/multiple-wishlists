<div class="flex flex-col">
    <x-rapidez-ct::title href="/account/wishlists">@{{ wishlist.title }}</x-rapidez-ct::title>
    <div v-if="wishlist.shared" class="text-sm text-ct-primary">
        @lang('Sharing link:') <a :href="'{{ route('wishlist.shared','') }}/' + wishlist.sharing_token" class="text-ct-inactive underline">{{ route('wishlist.shared','') }}/@{{wishlist.sharing_token}}</a>
    </div>
</div>