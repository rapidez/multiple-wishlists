@extends('rapidez::account.partials.layout')

@section('title', __('Wishlists'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <div class="container mx-auto">
        <wishlist v-slot="{ wishlists, addWishlist, removeWishlist }">
            <div>
                <div class="flex flex-col" v-if="wishlists">
                    <div
                        class="text-gray-900 border odd:border-gray-200 even:border-white hover:border-gray-800 duration-100 rounded-md odd:bg-gray-200 flex flex-row w-full"
                        v-for="(wishlist, index) in wishlists"
                    >
                        <a class="flex gap-2 px-2 py-4 w-4/5 text-gray-500" :href="'{{ route('wishlist.show', '') }}/'+wishlist.id">
                            <div class="px-4 w-fit">@{{ index + 1 }}</div>
                            <div class="w-1/4 overflow-ellipsis overflow-hidden whitespace-nowrap font-semibold text-gray-600">@{{ wishlist.title }}</div>
                            <div class="px-4 w-40">@{{ wishlist.items.length }} @lang('items')</div>
                            <div class="w-full overflow-ellipsis overflow-hidden whitespace-nowrap text-gray-900">@{{ wishlist.description }}</div>
                        </a>
                        <div class="flex m-2 gap-2 h-10 self-center justify-end items-center w-1/5">
                            <a :href="'{{ route('wishlist.shared', '') }}/' + wishlist.sharing_token" v-if="wishlist.shared" class="text-primary hover:underline">
                                @lang('(shared)')
                            </a>
                            <x-rapidez::button v-if="wishlist" ::href="'{{ route('wishlist.edit', '') }}/' + wishlist.id">
                                @lang('Edit')
                            </x-rapidez::button>
                            <x-rapidez::button variant="outline" v-if="wishlist" @click="removeWishlist(wishlist)">
                                @lang('Delete')
                            </x-rapidez::button>
                        </div>
                    </div>
                </div>
                <x-rapidez::button variant="outline" class="self-start mt-2" @click="addWishlist('{{ __('New wishlist') }}')">
                    @lang('Create new wishlist')
                </x-rapidez::button>
            </div>
        </wishlist>
    </div>
@endsection
