<x-rapidez-mw::dropdown class="absolute right-0 top-11 w-60 flex flex-col p-4 sm:px-7 sm:py-6">
    <x-rapidez-mw::button.link v-if="wishlist" @click="toggleEdit">
        @lang('Change name')
        <x-heroicon-o-pencil-square class="size-5"/>
    </x-rapidez-mw::button.link>
    <hr class="border-t my-4" />
    <x-rapidez-mw::button.link v-if="wishlist" @click="removeWishlist(wishlist.id, true)">
        @lang('Delete wishlist')
        <x-heroicon-o-trash class="size-5"/>
    </x-rapidez-mw::button.link>
</x-rapidez-mw::dropdown>
