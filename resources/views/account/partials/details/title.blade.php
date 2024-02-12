<div class="flex flex-col">
    <template v-if="!editing">
        <div class="flex items-center">
            <x-rapidez-ct::title href="/account/wishlists">@{{ wishlist.title }}</x-rapidez-ct::title>
            @if ($editable)
                <x-rapidez-mw::button.accent class="ml-4 flex items-center justify-center !p-0 w-9 h-9" v-on:click="toggleEdit">
                    <x-heroicon-o-pencil-square class="w-4 h-4 text-white" />
                </x-rapidez-mw::button.accent>
            @endif
        </div>
        <div v-if="wishlist.shared" class="text-sm text-ct-primary flex flex-col">
            <span>@lang('Sharing link'): <a :href="shareUrl" class="text-ct-inactive underline">@{{ shareUrl }}</a></span>
            <template v-if="isSupported">
                <x-rapidez-mw::button.accent v-on:click="share">@lang('Share')</x-rapidez-mw::button.accent>
            </template>
        </div>
    </template>

    @if ($editable)
        <template v-else>
            <form class="flex flex-col" v-on:submit.stop="save">
                <div class="flex items-center">
                    <x-rapidez-ct::title href="/account/wishlists"></x-rapidez-ct::title>
                    <input type="text" v-model="editing.title">
                    <x-rapidez-mw::button.accent class="ml-4 flex items-center justify-center !p-0 w-9 h-9">
                        <x-heroicon-o-check class="w-4 h-4 text-white" />
                    </x-rapidez-mw::button.accent>
                </div>
                <textarea v-model="editing.description"></textarea>
                <input type="checkbox" v-model="editing.shared"> @lang('Share this wishlist')
            </form>
        </template>
    @endif
</div>
