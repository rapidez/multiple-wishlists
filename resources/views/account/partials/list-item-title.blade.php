<div class="flex items-center justfiy-between w-full font-medium text text-base mb-2.5 relative">
    <div class="w-full flex items-center gap-2">
        <span>@{{ wishlist.title }}</span>
        @include('rapidez-mw::account.partials.shared-wishlist')
    </div>
    <toggler v-slot="{ isOpen, toggle, close}" v-cloak>
        <div v-on-click-away="close">
            <button @click="toggle">
                <x-heroicon-o-ellipsis-horizontal class="size-5" />
            </button>
            <div v-show="isOpen" v-cloak>
                @include('rapidez-mw::account.partials.edit-wishlist')
            </div>
        </div>
    </toggler>
</div>