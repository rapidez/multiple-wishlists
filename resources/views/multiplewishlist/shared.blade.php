@extends('rapidez::layouts.app')

@section('title', __('Shared wishlist'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('content')
    <div class="container mx-auto" v-cloak>
        <h1 class="font-bold text-4xl my-3">@yield('title')</h1>
        <wishlist shared-id="{{ $token }}" v-slot="{ wishlist, findItem, editItem, removeItem }">
            @include('rapidez::multiplewishlist.partials.wishlist', ['editable' => false])
        </wishlist>
    </div>
@endsection
