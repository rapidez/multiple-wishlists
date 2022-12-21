@extends('rapidez::account.partials.layout')

@section('title', __('Wishlists'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <div class="container mx-auto">
        <api-request method="get" immediate destination="wishlists" v-slot="{ data, runQuery }">
            <div class="flex flex-col" v-if="data">
                <div class="text-gray-900 rounded-md odd:bg-gray-200 flex flex-row w-full" v-for="(wishlist, index) in data">
                    <a class="flex gap-2 px-2 py-4 w-full" :href="'/account/wishlists/'+wishlist.id">
                        <div class="px-4 w-fit">@{{ index + 1 }}</div>
                        <div class="w-1/4 font-semibold">@{{ wishlist.title }}</div>
                        <div class="px-4 w-40">@{{ wishlist.item_count }} items</div>
                        <div class="w-3/4">@{{ wishlist.description }}</div>
                    </a>
                    <a class="bg-primary text-white font-semibold px-4 py-2 m-2 rounded-md flex justify-center items-center" v-if="wishlist" :href="'/account/wishlists/edit/'+wishlist.id">Edit</a>
                    <api-request method="delete" :destination="'wishlists/' + wishlist.id" v-slot="{ runQuery, running }" :callback="runQuery">
                        <button class="bg-red-500 text-white font-semibold px-4 py-2 m-2 rounded-md flex justify-center items-center" v-if="wishlist" @click="runQuery">
                            @{{ running ? '...' : ' Delete' }}
                        </button>
                    </api-request>
                </div>

                <api-request method="post" destination="wishlists" v-slot="{ data, runQuery, running }" :callback="runQuery" :variables="{ title: 'New wishlist' }">
                    <button
                        @click="runQuery"
                        :disabled="running"
                        class="w-10 bg-gray-100 px-4 py-2 mt-2 rounded-md cursor-pointer"
                        :class="running ? 'bg-gray-200 cursor-not-allowed' : ''"
                    >
                        @{{ running ? '...' : '+' }}
                    </button>
                </api-request>
            </div>
        </api-request>
    </div>
@endsection