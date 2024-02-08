@extends('rapidez::account.partials.layout')

@section('title', __(''))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <wishlist :wishlist-id="{{ $id }}" v-slot="{ wishlist, findItem, editItem, removeItem }">
        @include('rapidez-mw::account.partials.details.wishlist')
    </wishlist>
    @include('rapidez-mw::account.partials.details.back-button')
@endsection
