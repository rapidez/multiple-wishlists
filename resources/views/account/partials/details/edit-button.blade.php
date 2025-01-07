@if($editable)
    <toggler v-slot="{ isOpen, toggle, close }" v-cloak>
        <div v-on-click-away="close">
            <button @click="toggle" class="flex items-center justify-center bg-white border rounded size-9">
                <x-heroicon-o-ellipsis-horizontal class="size-5" />
            </button>
            <div v-show="isOpen" v-cloak>
                @include('rapidez-mw::account.partials.details.edit')
            </div>
        </div>
    </toggler>
@endif
