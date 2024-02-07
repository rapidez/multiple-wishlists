@props(['productId' => $product->entity_id ?? null])

<toggler v-slot="{ isOpen, toggle, close }" v-cloak>
    <wishlist v-slot="{ wishlists, toggleItem, findItem, addWishlist, isWishlisted }">
        <div v-on-click-away="close" {{ $attributes->class('w-full') }}>
            @include('rapidez-mw::partials.item.button')
            <div v-show="isOpen" v-cloak>
                <x-rapidez-mw::dropdown class="relative px-2.5 py-3.5 -mx-2 sm:px-5 sm:mx-4">
                    @include('rapidez-mw::partials.item.login')
                    <template v-else>
                        <div class="flex flex-col gap-2">
                            <div v-for="wishlist in wishlists" :key="wishlist.id" class="flex gap-2 w-full items-start justify-between">
                                @include('rapidez-mw::partials.item.add')
                            </div>
                            @include('rapidez-mw::partials.item.new-list')
                        </div>
                    </template>
                </x-rapidez-mw::dropdown>
            </div>
        </div>
    </wishlist>
</toggler>
