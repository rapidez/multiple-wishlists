@extends('rapidez::account.partials.layout')

@section('title', __('Wishlist'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <a class="text-primary underline" href="{{ route('wishlist.listing') }}">Back to listing</a>
    <wishlist :wishlist-id="{{ $id }}" v-slot="{ wishlist, contains, editItem, removeItem }">
        @include('rapidez::multiplewishlist.partials.wishlist')
    </wishlist>
@endsection
