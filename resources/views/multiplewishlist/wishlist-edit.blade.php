@extends('rapidez::account.partials.layout')

@section('title', __('Wishlist'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <wishlist :wishlist-id="{{ $id }}" v-slot="{ wishlist, editWishlist, tempWishlist }">
        <div v-if="wishlist">
            <x-rapidez::input name="title" v-model="tempWishlist.title" required/>
            <x-rapidez::textarea name="description" v-model="tempWishlist.description"/>
            <x-rapidez::checkbox name="shared" v-model="tempWishlist.shared">@lang('Enable public wishlist sharing link')</x-rapidez::checkbox>
            <div class="flex gap-2">
                <button
                    @click="editWishlist(wishlist, tempWishlist.title, tempWishlist.description, tempWishlist.shared, '{{ route('wishlist.show', '') }}/' + wishlist.id)"
                    class="bg-primary text-white hover:bg-white hover:text-primary transition border border-primary px-4 py-2 mt-2 rounded-md cursor-pointer"
                >
                    @lang('Save')
                </button>
                <a
                    href="{{ route('wishlist.show', $id) }}"
                    class="bg-red-500 text-white hover:bg-white hover:text-red-500 transition border border-red-500 px-4 py-2 mt-2 rounded-md cursor-pointer"
                >
                    @lang('Cancel')
                </a>
            </div>
        </div>
    </wishlist>
@endsection
