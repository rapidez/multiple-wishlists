<button v-if="window.app.config.globalProperties.loggedIn.value" class="p-3" @click="toggle" aria-label="@lang('Add to wishlist')">
    <x-heroicon-s-heart v-if="isWishlisted({{ $productId }})" class="size-5 text hover:opacity-80" />
    <x-heroicon-o-heart v-else="" v-bind:class="{ 'text-primary': isOpen, 'text-muted hover:text-primary': !isOpen }" class="size-5 transition" />
</button>

<button v-else class="p-3" @click="toggle" aria-label="@lang('Add to wishlist')">
    <x-heroicon-o-heart v-bind:class="{ 'text-primary': isOpen, 'text-muted hover:text-primary': !isOpen }" class="size-5 transition" />
</button>
