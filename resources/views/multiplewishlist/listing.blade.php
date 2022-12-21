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
                        <div class="w-1/4 font-semibold text-gray-600">@{{ wishlist.title }}</div>
                        <div class="px-4 w-40">@{{ wishlist.item_count }} items</div>
                        <div class="w-full overflow-ellipsis overflow-hidden whitespace-nowrap text-gray-900">@{{ wishlist.description }}</div>
                    </a>
                    <div class="flex m-2 gap-2 h-10 self-center justify-end items-center w-1/5">
                        <a :href="'/wishlists/shared/' + wishlist.sharing_token" v-if="wishlist.shared" class="text-primary">(shared)</a>
                        <a class="bg-primary text-white hover:bg-white hover:text-primary transition border border-primary font-semibold px-4 py-2 rounded-md flex justify-center items-center" v-if="wishlist" :href="'/account/wishlists/edit/'+wishlist.id">Edit</a>
                        <api-request method="delete" :destination="'wishlists/' + wishlist.id" v-slot="{ runQuery, running }" :callback="runQuery">
                            <button class="bg-red-500 text-white hover:bg-white hover:text-red-500 transition border border-red-500 font-semibold px-4 py-2 rounded-md flex justify-center items-center" v-if="wishlist" @click="runQuery">
                                @{{ running ? '...' : ' Delete' }}
                            </button>
                        </api-request>
                    </div>
                </div>

                <api-request method="post" destination="wishlists" v-slot="{ data, runQuery, running }" :callback="runQuery" :variables="{ title: 'New wishlist' }">
                    <button
                        @click="runQuery"
                        :disabled="running"
                        class="self-start bg-gray-500 text-white hover:bg-white hover:text-gray-500 transition border border-gray-500 px-4 py-2 mt-4 rounded-full cursor-pointer"
                        :class="running ? 'cursor-not-allowed' : ''"
                    >
                        @{{ running ? '...' : 'Create new wishlist' }}
                    </button>
                </api-request>
            </div>
        </api-request>
    </div>
@endsection