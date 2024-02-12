@extends('rapidez::account.partials.layout')

@section('title', '')

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <wishlist :wishlist-id="{{ $id }}" v-slot="{ wishlist, removeWishlist, addAllToCart, adding, added, editing, toggleEdit, save }">
        @include('rapidez-mw::account.partials.details.wishlist')
    </wishlist>
    @include('rapidez-mw::account.partials.details.back-button')
@endsection
