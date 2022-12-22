@props(['editable' => true])
<div v-if="data" :set="$root.custom.currentWishlistData = data" class="mt-5">
    <div class="flex justify-between">
        <div class="flex">
            <p class="font-bold ml-4">@{{ data[0].title }}</p>
            @if($editable)
                <a class="text-primary underline ml-4" href="/account/wishlists/edit/{{ $id }}">Edit</a>
            @endif
        </div>
        <div v-if="data[0].shared" class="text-sm text-gray-600">
            Sharing link: <a :href="'/wishlists/shared/' + data[0].sharing_token" class="text-primary underline">/wishlists/shared/@{{data[0].sharing_token}}</a>
        </div>
    </div>
    <div v-if="data[0].description" class="p-4 rounded-md bg-gray-100 mt-4 mb-6 whitespace-pre-line">
        <p>@{{ data[0].description }}</p>
    </div>
    <listing v-cloak>
        <div slot-scope="{ loaded }">
            <reactive-base :app="config.es_prefix + '_products_' + config.store" :url="config.es_url" v-if="loaded">
                <reactive-list id="products" component-id="products" data-field="sku.keyword" :default-query="function() { return { query: { terms: { 'sku.keyword': data[1].map(e => e.sku) } } } }">
                    <div slot="renderResultStats"></div>
                    <div slot="renderNoResults">This wishlist is empty.</div>
                    <div slot="render" slot-scope="{ data, dataItem }" class="flex flex-col">
                        <div class="self-end p-4" v-if="data.length > 1">
                            <x-rapidez::button
                                type="primary"
                                @click.prevent="$root.$refs['addToCart'].forEach(e => e.click())"
                            >
                                Add all items to cart
                            </x-rapidez::button>
                        </div>
                        <div v-for="item in data" class="rounded-md even:bg-gray-200 flex items-center justify-between p-4" :set="dataItem=$root.custom.currentWishlistData[1].find(e => e.sku == item.sku)">
                            <template v-if="dataItem">
                                <a :href="item.url" class="flex gap-2 w-full">
                                    <picture v-if="item.thumbnail">
                                        <source :srcset="'/storage/resizes/200/catalog/product' + item.thumbnail + '.webp'" type="image/webp">
                                        <img :src="'/storage/resizes/200/catalog/product' + item.thumbnail" class="object-contain rounded-md h-40" :alt="item.name" loading="lazy" />
                                    </picture>
                                    <div class="w-full flex flex-col">
                                        <span class="font-bold text-20">@{{ item.name }}</span>
                                        <span>@{{ item.price | price }}</span>
                                    </div>
                                </a>
                                <div class="flex gap-3 pr-10">
                                    <template v-if="dataItem.type_id == 'simple'">
                                        @include('rapidez::multiplewishlist.partials.addtocart', ['product' => 'item'])
                                    </template>
                                    @if($editable)
                                        <api-request method="delete" :destination="'wishlists/item/' + dataItem.id" :variables="{ wishlistId: {{ $id }} }" v-slot="{ runQuery }" :callback="() => window.Vue.delete($root.custom.currentWishlistData[1], index)">
                                            <button class="w-14 h-14 border border-red-600 bg-red-600 text-white hover:bg-white hover:text-red-600 transition rounded-md" @click="runQuery">X</button>
                                        </api-request>
                                    @endif
                                </div>
                            </template>
                        </div>
                    </div>
                </reactive-list>
            </reactive-base>
        </div>
    </listing>
</div>