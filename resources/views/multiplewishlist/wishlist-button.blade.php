@props(['productId' => $product->entity_id])

<toggler v-slot="{ isOpen, toggle, close }" v-cloak>
    <div class="absolute right-0 top-0">
        <button class="p-2" @click="toggle">
            <x-heroicon-s-heart class="w-6 h-6" v-if="!isOpen"/>
            <x-heroicon-o-heart class="w-6 h-6" v-else/>
        </button>
        <div v-show="isOpen" v-if="$root.user" v-cloak class="absolute right-0 border rounded-md bg-gray-100 p-5 w-64">
            <lazy>
                <wishlist v-slot="{ wishlists, toggleItem, findItem, addWishlist }">
                    <div class="flex flex-col gap-2">
                        <div v-for="wishlist in wishlists" :key="wishlist.id" class="flex gap-2 w-full items-center justify-end">
                            <a class="overflow-ellipsis overflow-hidden whitespace-nowrap" :href="'{{ route('wishlist.show', '') }}/' + wishlist.id">
                                @{{ wishlist.title }}
                            </a>
                            <div class="border border-primary rounded-md w-fit inline-block self-start transition" :class="findItem(wishlist, {{ $productId }}) ? 'text-white bg-primary' : 'text-primary'">
                                <button class="p-2" @click="toggleItem(wishlist, {{ $productId }})">
                                    <x-heroicon-s-heart class="w-6 h-6"/>
                                </button>
                            </div>
                        </div>
                        <x-rapidez::button variant="outline" @click="addWishlist('New wishlist')">
                            +
                        </x-rapidez::button>
                    </div>
                </wishlist>
            </lazy>
        </div>
    </div>
</toggler>
