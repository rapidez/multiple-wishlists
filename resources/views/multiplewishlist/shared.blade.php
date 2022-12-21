@extends('rapidez::account.partials.layout')

@section('title', __('Wishlist'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <api-request method="get" immediate destination="wishlists/shared/{{ $token }}" v-slot="{ data, runQuery }" checkfail="/" check="data[0].title">
        @include('rapidez::multiplewishlist.partials.wishlist', ['editable' => false])
    </api-request>
@endsection