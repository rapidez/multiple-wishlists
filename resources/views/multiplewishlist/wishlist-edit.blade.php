@extends('rapidez::account.partials.layout')

@section('title', __('Wishlist'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <api-request method="get" immediate destination="wishlists/{{ $id }}" v-slot="{ data }" checkfail="/account/wishlists/" check="data[0].title">
        <div v-if="data">
            <x-rapidez::input name="title" v-model="data[0].title" required/>
            <x-rapidez::textarea name="description" v-model="data[0].description"/>
            <x-rapidez::checkbox name="shared" v-model="data[0].shared">Enable public wishlist sharing link</x-rapidez::checkbox>
            <div class="flex gap-2">
                <api-request method="patch" destination="wishlists/{{ $id }}" redirect="/account/wishlists/{{ $id }}" :variables="{title: data[0].title, description: data[0].description, share: data[0].shared}" v-slot="{ data, runQuery, running }">
                    <button
                        @click="runQuery"
                        :disabled="running"
                        class="bg-primary text-white hover:bg-white hover:text-primary transition border border-primary px-4 py-2 mt-2 rounded-md cursor-pointer"
                        :class="running ? 'bg-gray-200 cursor-not-allowed' : ''"
                    >
                        @{{ running ? '...' : 'Save' }}
                    </button>
                </api-request>
                <a href="/account/wishlists/{{ $id }}" class="bg-red-500 text-white hover:bg-white hover:text-red-500 transition border border-red-500 px-4 py-2 mt-2 rounded-md cursor-pointer">Cancel</a>
            </div>
        </div>
    </api-request>
@endsection