@extends('rapidez::account.partials.layout')

@section('title', __('My Wishlists'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <wishlist v-slot="{ wishlists, addWishlist, removeWishlist }">
        <div>
            <div v-if="wishlists" class="space-y-0.5 my-5">
                <div
                    v-for="(wishlist, index) in wishlists"
                    class="bg-muted p-6 sm:px-9 sm:pt-6 sm:pb-9 rounded flex flex-col gap-3"
                    :key="wishlist.id"
                >
                    <div class="flex flex-col">
                        @include('rapidez-mw::account.partials.list-item-title')
                        @include('rapidez-mw::account.partials.list-item')
                    </div>
                </div>
            </div>
            @include('rapidez-mw::account.partials.buttons')
        </div>
    </wishlist>
@endsection
