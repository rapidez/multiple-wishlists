@extends('rapidez::account.partials.layout')

@section('title', __('Wishlist'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <a class="text-primary underline" href="/account/wishlists/">Back to listing</a>
    <api-request method="get" immediate destination="wishlists/{{ $id }}" v-slot="{ data }" checkfail="/account/wishlists/" check="data[0].title">
        @include('rapidez::multiplewishlist.partials.wishlist')
    </api-request>
@endsection