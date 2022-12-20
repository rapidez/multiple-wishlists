@extends('rapidez::account.partials.layout')

@section('title', __('Wishlist'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <api-request method="get" immediate destination="wishlists/{{ $id }}" v-slot="{ data }">
        @include('rapidez::multiplewishlist.partials.wishlist')
    </api-request>
@endsection