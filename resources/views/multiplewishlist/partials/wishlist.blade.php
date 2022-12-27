@props(['editable' => true])
<div v-if="data" :set="$root.custom.currentWishlistData = data" class="mt-5">
    <div class="flex justify-between">
        <div class="flex">
            <p class="font-bold ml-4">@{{ data.title }}</p>
            @if($editable)
                <a class="text-primary underline mx-4" href="/account/wishlists/edit/{{ $id }}">Edit</a>
            @endif
        </div>
        <div v-if="data.shared" class="text-sm text-gray-600">
            Sharing link: <a :href="'/wishlists/shared/' + data.sharing_token" class="text-primary underline">/wishlists/shared/@{{data.sharing_token}}</a>
        </div>
    </div>
    <div v-if="data.description" class="p-4 rounded-md bg-gray-100 mt-4 mb-6 whitespace-pre-line">
        <p>@{{ data.description }}</p>
    </div>
    <listing v-cloak>
        <div slot-scope="{ loaded }">
            <reactive-base :app="config.es_prefix + '_products_' + config.store" :url="config.es_url" v-if="loaded">
                <reactive-list id="products" component-id="products" data-field="id" :default-query="function() { return { query: { terms: { 'id': data.items.map(e => e.product_id) } } } }">
                    <div slot="renderResultStats"></div>
                    <div slot="renderNoResults">This wishlist is empty.</div>
                    <div slot="render" slot-scope="{ data, dataItem }" class="flex flex-col">
                        <div class="self-end p-4">
                            <template v-if="data.length > 1">
                                <x-rapidez::button type="primary" @click.prevent="$root.$refs['addToCart'].forEach(e => e.click())">
                                    Add all items to cart
                                </x-rapidez::button>
                            </template>
                        </div>
                        <div v-for="(item, index) in data" class="text-gray-900 border even:border-gray-200 odd:border-white hover:border-gray-800 duration-100 rounded-md even:bg-gray-200 flex items-center justify-between p-4" :set="dataItem=$root.custom.currentWishlistData.items.find(e => e.product_id == item.id)">
                            <template v-if="dataItem">
                                <a :href="item.url" class="flex gap-2 w-full">
                                    <picture v-if="item.thumbnail">
                                        <source :srcset="'/storage/resizes/200/catalog/product' + item.thumbnail + '.webp'" type="image/webp">
                                        <img :src="'/storage/resizes/200/catalog/product' + item.thumbnail" class="object-contain rounded-md h-40" :alt="item.name" loading="lazy" />
                                    </picture>
                                    <div class="w-full flex flex-col">
                                        <span class="font-bold text-20">@{{ item.name }} x @{{ Math.round(dataItem.qty) }}</span>
                                        <span>@{{ item.price | price }}</span>
                                        <span class="text-gray-700 ml-2">@{{ dataItem.description }}</span>
                                    </div>
                                </a>
                                @if($editable)
                                    <div class="flex flex-col w-full px-5">
                                        <template v-if="$root.custom.itemEdit == item.id">
                                            <x-rapidez::input
                                                class="text-right"
                                                type="number"
                                                name="quantity"
                                                v-model="$root.custom.currentItem.qty"
                                                v-bind:dusk="'qty-'+index"
                                                ::min="item.min_sale_qty > item.qty_increments ? item.min_sale_qty : item.qty_increments"
                                                ::step="item.qty_increments"
                                            />
                                            <x-rapidez::textarea name="description" v-model="$root.custom.currentItem.description"/>
                                            <api-request
                                                method="patch"
                                                :destination="'wishlists/item/' + $root.custom.currentItem.wishlist_item_id"
                                                :variables="{
                                                    wishlistId: {{ $id }},
                                                    description: $root.custom.currentItem.description,
                                                    qty: $root.custom.currentItem.qty
                                                }"
                                                :callback="() => $root.custom.itemEdit=-1"
                                                v-slot="{ runQuery }"
                                            >
                                                <x-rapidez::button
                                                    variant="outline"
                                                    class="w-40 text-center self-center"
                                                    @click="runQuery"
                                                >
                                                    Save item
                                                </x-rapidez::button>
                                            </api-request>
                                        </template>
                                        <template v-else>
                                            <x-rapidez::button
                                                variant="outline"
                                                class="w-40 text-center self-center"
                                                @click="
                                                    $root.custom.itemEdit=item.id;
                                                    $root.custom.currentItem=$root.custom.currentWishlistData.items.find(e => e.product_id == item.id);
                                                    $root.custom.currentItem.qty = Math.round($root.custom.currentItem.qty);
                                                "
                                            >
                                                Edit item
                                            </x-rapidez::button>
                                        </template>
                                    </div>
                                @endif
                                <div class="flex gap-3 pr-10">
                                    <template v-if="item.type == 'simple'">
                                        @include('rapidez::multiplewishlist.partials.addtocart', ['product' => 'item', 'qty' => 'dataItem.qty'])
                                    </template>
                                    @if($editable)
                                        <api-request 
                                            method="delete"
                                            :destination="'wishlists/item/' + dataItem.wishlist_item_id"
                                            :variables="{ wishlistId: {{ $id }} }"
                                            v-slot="{ runQuery }"
                                            :callback="() => window.Vue.delete($root.custom.currentWishlistData.items, $root.custom.currentWishlistData.items.findIndex(e => e.product_id == item.id))"
                                        >
                                            <button class="w-14 h-14 border border-red-600 bg-red-600 text-white hover:bg-white hover:text-red-600 transition rounded-md" @click="runQuery">X</button>
                                        </api-request>
                                    @endif
                                </div>
                            </template>
                            <template v-else>
                                <div class="flex w-full justify-center items-center p-5 italic text-gray-600">
                                    Item deleted
                                </div>
                            </template>
                        </div>
                    </div>
                </reactive-list>
            </reactive-base>
        </div>
    </listing>
</div>