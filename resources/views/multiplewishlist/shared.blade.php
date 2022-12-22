@extends('rapidez::layouts.app')

@section('title', __('Shared wishlist'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('content')
    <div class="container mx-auto" v-cloak>
        <h1 class="font-bold text-4xl my-3">@yield('title')</h1>
        <api-request method="get" immediate destination="wishlists/shared/{{ $token }}" v-slot="{ data, runQuery }" checkfail="/" check="data[0].title">
            @include('rapidez::multiplewishlist.partials.wishlist', ['editable' => false])
        </api-request>
    </div>
@endsection