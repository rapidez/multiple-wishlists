<div class="flex flex-col overflow-hidden">
    @include('rapidez-mw::partials.item.title')
    @include('rapidez-mw::partials.item.view')
</div>
<button @click="toggleItem(wishlist, {{ $productId }})">
    <x-heroicon-s-heart v-if="findItem(wishlist, {{ $productId }})" class="size-5 text hover:opacity-80" />
    <x-heroicon-o-heart v-else="" class="size-5 text-muted hover:text-primary" />
</button>