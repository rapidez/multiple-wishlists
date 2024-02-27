<div class="flex flex-col">
    @include('rapidez-mw::partials.item.title')
    @include('rapidez-mw::partials.item.view')
</div>
<button @click="toggleItem(wishlist, {{ $productId }})">
    <x-heroicon-s-heart v-if="findItem(wishlist, {{ $productId }})" class="w-5 h-5 text-ct-wishlist hover:opacity-80" />
    <x-heroicon-o-heart v-else class="w-5 h-5 text-ct-border hover:text-ct-primary" />
</button>