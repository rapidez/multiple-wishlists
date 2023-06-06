@props(['editable' => true])

<div v-if="wishlist">
    <div class="flex justify-between">
        <div class="flex">
            <p class="font-bold ml-4">@{{ wishlist.title }}</p>
            @if($editable)
                <a class="text-primary underline mx-4" :href="'{{ route('wishlist.edit','') }}/' + wishlist.id">@lang('Edit')</a>
            @endif
        </div>
        <div v-if="wishlist.shared" class="text-sm text-gray-600">
            @lang('Sharing link:') <a :href="'{{ route('wishlist.shared','') }}/' + wishlist.sharing_token" class="text-primary underline">{{ route('wishlist.shared','') }}/@{{wishlist.sharing_token}}</a>
        </div>
    </div>
    <div v-if="wishlist.description" class="p-4 rounded-md bg-gray-100 mt-4 mb-6 whitespace-pre-line">
        <p>@{{ wishlist.description }}</p>
    </div>
    <listing v-cloak>
        <div slot-scope="{ loaded }">
            <reactive-base :app="config.es_prefix + '_products_' + config.store" :url="config.es_url" v-if="loaded">
                <reactive-list id="products" component-id="products" data-field="id" :default-query="function() { return { query: { terms: { 'id': wishlist.items.map(e => e.product_id) } } } }">
                    <div slot="renderResultStats"></div>
                    <div slot="renderNoResults">@lang('This wishlist is empty.')</div>
                    <div slot="render" slot-scope="{ data }" class="flex flex-col">
                        <div class="self-end p-4">
                            <template v-if="data.length > 1">
                                <x-rapidez::button.primary @click.prevent="$root.$refs['addToCart'].forEach(e => e.click())">
                                    @lang('Add all items to cart')
                                </x-rapidez::button.primary>
                            </template>
                        </div>
                        <div
                            v-for="(item, index) in data"
                            class="text-gray-900 border even:border-gray-200 odd:border-white hover:border-gray-800 duration-100 rounded-md even:bg-gray-200 flex items-center justify-between p-4"
                            :key="item.id"
                        >
                            <template v-if="findItem(wishlist, item.id)">
                                <a :href="item.url" class="flex gap-2 w-1/2">
                                    <picture v-if="item.thumbnail">
                                        <source :srcset="'/storage/resizes/200/catalog/product' + item.thumbnail + '.webp'" type="image/webp">
                                        <img :src="'/storage/resizes/200/catalog/product' + item.thumbnail" class="object-contain rounded-md h-40" :alt="item.name" loading="lazy" />
                                    </picture>
                                    <div class="w-full flex flex-col">
                                        <span class="font-bold text-20">@{{ item.name }}</span>
                                        <span>@{{ item.price | price }}</span>
                                    </div>
                                </a>
                                @if($editable)
                                    <div class="flex justify-between w-full">
                                        <textarea
                                            class="text-gray-700 mx-2 w-full"
                                            @focusout="editItem(wishlist, item.id, { description: $event.target.value })"
                                            v-model.lazy="findItem(wishlist, item.id).description"
                                        ></textarea>
                                        <div class="flex flex-col px-5">
                                            <div class="flex gap-3 pr-10">
                                                <template v-if="item.type == 'simple'">
                                                    @include('rapidez::multiplewishlist.partials.addtocart', ['product' => 'item', 'qty' => 'findItem(wishlist, item.id).qty'])
                                                </template>
                                                @if($editable)
                                                    <button
                                                        class="w-14 h-14 border border-red-600 bg-red-600 text-white hover:bg-white hover:text-red-600 transition rounded-md"
                                                        @click="removeItem(wishlist, item.id)"
                                                    >
                                                        X
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-gray-700 mx-2 w-full">
                                        @{{ findItem(wishlist, item.id).description }}
                                    </div>
                                @endif
                            </template>
                            <div v-else class="text-center w-full italic text-gray-700 p-5">
                                @lang('Deleted')
                            </div>
                        </div>
                    </div>
                </reactive-list>
            </reactive-base>
        </div>
    </listing>
</div>
