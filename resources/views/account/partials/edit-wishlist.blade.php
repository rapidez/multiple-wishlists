<x-rapidez-mw::dropdown class="absolute right-0 top-6 w-60 flex flex-col p-4 sm:px-7 sm:py-6">
    <x-rapidez-mw::button.link v-if="wishlist" v-bind:href="'{{ route('wishlist.show', '') }}/'+wishlist.id">
        @lang('Edit')
        <x-heroicon-o-pencil-square class="size-5"/>
    </x-rapidez-mw::button.link>
    <hr class="border-t my-4" />
    <x-rapidez-mw::button.link v-if="wishlist" @click="removeWishlist(wishlist.id)">
        @lang('Delete wishlist')
        <x-heroicon-o-trash class="size-5"/>
    </x-rapidez-mw::button.link>
</x-rapidez-mw::dropdown>
