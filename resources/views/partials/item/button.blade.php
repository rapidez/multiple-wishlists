<button v-if="$root.loggedIn" class="p-3" @click="toggle">
    <x-heroicon-s-heart v-if="isWishlisted({{ $productId }})" class="w-5 h-5 text-ct-error hover:opacity-80" />
    <x-heroicon-o-heart v-else v-bind:class="{ 'text-ct-primary': isOpen, 'text-ct-border hover:text-ct-primary': !isOpen }" class="w-5 h-5 transition" />
</button>

<button v-else class="p-3" @click="toggle">
    <x-heroicon-o-heart v-bind:class="{ 'text-ct-primary': isOpen, 'text-ct-border hover:text-ct-primary': !isOpen }" class="w-5 h-5 transition" />
</button>
