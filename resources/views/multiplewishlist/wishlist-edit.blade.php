@extends('rapidez::account.partials.layout')

@section('title', __('Wishlist'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <wishlist :wishlist-id="{{ $id }}" v-slot="{ wishlist, editWishlist }">
        <div v-if="wishlist">
            <x-rapidez::input name="title" v-model="wishlist.title" required/>
            <x-rapidez::textarea name="description" v-model="wishlist.description"/>
            <x-rapidez::checkbox name="shared" v-model="wishlist.shared">Enable public wishlist sharing link</x-rapidez::checkbox>
            <div class="flex gap-2">
                <button
                    @click="editWishlist(wishlist, wishlist.title, wishlist.description, wishlist.shared, '/account/wishlists/' + wishlist.id)"
                    class="bg-primary text-white hover:bg-white hover:text-primary transition border border-primary px-4 py-2 mt-2 rounded-md cursor-pointer"
                >
                    Save
                </button>
                <a
                    href="/account/wishlists/{{ $id }}"
                    class="bg-red-500 text-white hover:bg-white hover:text-red-500 transition border border-red-500 px-4 py-2 mt-2 rounded-md cursor-pointer"
                >
                    Cancel
                </a>
            </div>
        </div>
    </wishlist>
@endsection