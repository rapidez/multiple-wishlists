<div class="flex flex-col">
    <div class="flex items-center">
        <x-rapidez-ct::title href="/account/wishlists">@{{ wishlist.title }}</x-rapidez-ct::title>
        <x-rapidez-mw::button.accent class="flex items-center justify-center !p-0 w-9 h-9">
            <x-heroicon-o-pencil-square class="w-4 h-4 text-white" />
        </x-rapidez-mw::button.accent>
    </div>
    <div v-if="wishlist.shared" class="text-sm text-ct-primary">
        @lang('Sharing link:') <a :href="'{{ route('wishlist.shared','') }}/' + wishlist.sharing_token" class="text-ct-inactive underline">{{ route('wishlist.shared','') }}/@{{wishlist.sharing_token}}</a>
    </div>
</div>