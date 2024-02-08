<x-rapidez-mw::dropdown class="absolute right-0 top-11 w-60 flex flex-col p-4 sm:px-7 sm:py-6">
    <x-rapidez-mw::button.link v-if="wishlist">
        @lang('Change name')
        <x-heroicon-o-pencil-square class="w-5 h-5"/>
    </x-rapidez-mw::button.link>
    <hr class="border-t my-4" />
    <x-rapidez-mw::button.link v-if="wishlist" @click="removeWishlist(wishlist)">
        @lang('Delete wishlist')
        <x-heroicon-o-trash class="w-5 h-5"/>
    </x-rapidez-mw::button.link>
</x-rapidez-mw::dropdown>