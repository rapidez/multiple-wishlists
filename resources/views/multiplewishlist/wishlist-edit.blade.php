@extends('rapidez::account.partials.layout')

@section('title', __('Wishlist'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <api-request method="get" immediate destination="wishlists/{{ $id }}" v-slot="{ data }">
        <div v-if="data">
            <x-rapidez::input name="title" v-model="data[0].title" required/>
            <x-rapidez::textarea name="description" v-model="data[0].description"/>
            <api-request method="patch" destination="wishlists/{{ $id }}" redirect="/account/wishlists/{{ $id }}" :variables="{title: data[0].title, description: data[0].description, share: data[0].shared}" v-slot="{ data, runQuery, running }">
                <button
                    @click="runQuery"
                    :disabled="running"
                    class="bg-gray-100 px-4 py-2 mt-2 rounded-md cursor-pointer"
                    :class="running ? 'bg-gray-200 cursor-not-allowed' : ''"
                >
                    @{{ running ? '...' : 'Save' }}
                </button>
            </api-request>
        </div>
    </api-request>
@endsection