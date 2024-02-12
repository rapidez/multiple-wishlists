@extends('rapidez::layouts.app')

@section('title', '')

@section('robots', 'NOINDEX,NOFOLLOW')

@section('content')
    <div class="container mx-auto" v-cloak>
        <wishlist shared-id="{{ $token }}" v-slot="{ wishlist, shareUrl, share, isSupported, addAllToCart, adding, added, editing }">
            @include('rapidez-mw::account.partials.details.wishlist', ['editable' => false])
        </wishlist>
    </div>
@endsection
