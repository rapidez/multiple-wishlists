<div class="flex flex-wrap w-full justify-between gap-2">
    <x-rapidez::button.outline href="/account">
        @lang('Back to dashboard')
    </x-rapidez::button.outline>
    <x-rapidez::button.secondary v-on:click="addWishlist('{{ __('New wishlist') }}')">
        @lang('Create new wishlist')
    </x-rapidez::button.secondary>
</div>
