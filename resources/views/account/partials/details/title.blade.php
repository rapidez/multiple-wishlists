<div class="flex flex-col">
    <template v-if="!editing">
        <x-rapidez-ct::title href="/account/wishlists">@{{ wishlist.title }}</x-rapidez-ct::title>
        <div v-if="wishlist.shared" class="text-sm text-muted flex flex-col mt-2 gap-y-2">
            <span>@lang('Sharing link'): <a :href="shareUrl" class="text-primary underline">@{{ shareUrl }}</a></span>
            <template v-if="isSupported">
                <x-rapidez::button.secondary v-on:click="share">@lang('Share')</x-rapidez::button.secondary>
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
                        <x-rapidez::button.secondary class="!absolute -translate-y-1/2 top-1/2 right-1  ml-4 flex items-center justify-center !p-0 size-9">
                            <x-heroicon-o-pencil-square class="size-5 text-white" />
                        </x-rapidez::button.secondary>
                    </div>
                </div>
                <x-rapidez::textarea class="mt-2.5" label="" name="Description" v-model="editing.description"></x-rapidez::textarea>
                <x-rapidez::input.checkbox class="mt-2.5" v-model="editing.shared">@lang('Share this wishlist')</x-rapidez::checkbox>
            </form>
        </template>
    @endif
</div>
