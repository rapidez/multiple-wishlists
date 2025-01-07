<toggler :callback="(opened) => {
    if (opened) {
        $root.$nextTick(() => $root.$refs['editing_' + wishlist.id]?.[0]?.focus())
    } else {
        update(wishlist.id, wishlist)
    }
}">
    <div class="flex items-center" slot-scope="{ toggle, close, isOpen }">
        <template v-if="!isOpen">
            <span class="text-primary truncate peer place-self-start -mt-0.5">
                @{{ wishlist.title }}
            </span>
            <x-heroicon-s-pencil-square
                class="pl-2 w-6 h-4 cursor-pointer shrink-0 opacity-0 hover:opacity-100 peer-hover:opacity-50 transition-opacity"
                v-on:click="toggle"
            />
        </template>
        <template v-else>
            <input
                v-bind:ref="'editing_' + wishlist.id"
                class="!font-[inherit] text-primary -mt-0.5 w-full !outline-none"
                v-model.lazy="wishlist.title"
                v-on-click-away="close"
                v-on:keyup.enter="close"
            />
        </template>
    </div>
</toggler>
