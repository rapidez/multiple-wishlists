@extends('rapidez::account.partials.layout')

@section('title', __('Wishlists'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <div class="container mx-auto">
        <api-request method="get" immediate destination="wishlists" v-slot="{ data, runQuery }">
            <div class="flex flex-col" v-if="data">
                <div class="text-gray-900 border odd:border-gray-200 even:border-white hover:border-gray-800 duration-100 rounded-md odd:bg-gray-200 flex flex-row w-full" v-for="(wishlist, index) in data">
                    <a class="flex gap-2 px-2 py-4 w-4/5 text-gray-500" :href="'/account/wishlists/'+wishlist.id">
                        <div class="px-4 w-fit">@{{ index + 1 }}</div>
                        <div class="w-1/4 overflow-ellipsis overflow-hidden whitespace-nowrap font-semibold text-gray-600">@{{ wishlist.title }}</div>
                        <div class="px-4 w-40">@{{ wishlist.item_count }} items</div>
                        <div class="w-full overflow-ellipsis overflow-hidden whitespace-nowrap text-gray-900">@{{ wishlist.description }}</div>
                    </a>
                    <div class="flex m-2 gap-2 h-10 self-center justify-end items-center w-1/5">
                        <a :href="'/wishlists/shared/' + wishlist.sharing_token" v-if="wishlist.shared" class="text-primary hover:underline">(shared)</a>
                        <x-rapidez::button v-if="wishlist" ::href="'/account/wishlists/edit/'+wishlist.id">Edit</x-rapidez::button>
                        <api-request method="delete" :destination="'wishlists/' + wishlist.id" v-slot="{ runQuery, running }" :callback="runQuery">
                            <x-rapidez::button variant="outline" v-if="wishlist" @click="runQuery">
                                @{{ running ? '...' : ' Delete' }}
                            </x-rapidez::button>
                        </api-request>
                    </div>
                </div>

                <api-request method="post" destination="wishlists" v-slot="{ data, runQuery, running }" :callback="runQuery" :variables="{ title: 'New wishlist' }">
                    <x-rapidez::button variant="outline" class="self-start mt-2" @click="runQuery" v-bind:disabled="running">
                        @{{ running ? '...' : 'Create new wishlist' }}
                    </x-rapidez::button>
                </api-request>
            </div>
        </api-request>
    </div>
@endsection