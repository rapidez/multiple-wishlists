<div class="flex flex-col">
    <template v-if="!editing">
        <x-rapidez-ct::title href="/account/wishlists">@{{ wishlist.title }}</x-rapidez-ct::title>
        <div v-if="wishlist.shared" class="text-sm text-ct-inactive flex flex-col mt-2 gap-y-2">
            <span>@lang('Sharing link'): <a :href="shareUrl" class="text-ct-primary underline">@{{ shareUrl }}</a></span>
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
                    <div class="relative border rounded">
                        <x-rapidez::input class="w-80 border-0 pr-12" name="Edit title" type="text" v-model="editing.title" />
                        <x-rapidez-mw::button.accent class="!absolute -translate-y-1/2 top-1/2 right-1  ml-4 flex items-center justify-center !p-0 w-9 h-9">
                            <x-heroicon-o-pencil-square class="w-4 h-4 text-white" />
                        </x-rapidez-mw::button.accent>
                    </div>
                </div>
                <x-rapidez::textarea class="mt-2.5" label="" name="Description" v-model="editing.description"></x-rapidez::textarea>
                <x-rapidez-ct::input.checkbox class="mt-2.5" v-model="editing.shared">@lang('Share this wishlist')</x-rapidez::checkbox>
            </form>
        </template>
    @endif
</div>
