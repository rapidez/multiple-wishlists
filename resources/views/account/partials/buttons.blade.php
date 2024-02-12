<div class="flex flex-wrap w-full justify-between gap-2">
    <x-rapidez-mw::button.outline href="/account">
        @lang('Back to dashboard')
    </x-rapidez-mw::button.outline>
    <x-rapidez-mw::button.accent @click="addWishlist('{{ __('New wishlist') }}')">
        @lang('Create new wishlist')
    </x-rapidez-mw::button.accent>
</div>
