<div v-if="data" :set="$root.custom.currentWishlistData = data">
    <p class="font-bold">@{{ data[0].title }}</p>
    <p>@{{ data[0].description }}</p>
    <listing v-cloak>
        <div slot-scope="{ loaded, filters, sortOptions, reactiveFilters }" class="hidden">
            <reactive-base :app="config.es_prefix + '_products_' + config.store" :url="config.es_url" v-if="loaded">
                <reactive-list id="products" component-id="products" data-field="sku.keyword" :default-query="function() { return { query: { terms: { 'sku.keyword': data[1].map(e => e.sku) } } } }">
                    <div slot="renderItem" slot-scope="{ item }" :set="$root.custom.currentWishlistData[1].filter(e => e.sku == item.sku).forEach(e => e['item'] = item)" :setloaded="$root.custom.wishlistLoaded=true"></div>
                </reactive-list>
            </reactive-base>
        </div>
    </listing>
    <div class="flex flex-col">
        <div
            v-if="$root.custom.wishlistLoaded"
            v-for="(item, index) in $root.custom.currentWishlistData[1]"
            :key="item.id"
            class="rounded-md odd:bg-gray-200 flex items-center justify-between p-4"
        >
            <template v-if="item">
                <a :href="item.item.url" class="flex gap-2 w-full">
                    <picture v-if="item.item.thumbnail">
                        <source :srcset="'/storage/resizes/200/catalog/product' + item.item.thumbnail + '.webp'" type="image/webp">
                        <img :src="'/storage/resizes/200/catalog/product' + item.item.thumbnail" class="object-contain rounded-md h-40" :alt="item.name" loading="lazy" />
                    </picture>
                    <div class="w-full flex flex-col">
                        <span class="font-bold text-20">@{{ item.item.name }}</span>
                        <span>@{{ item.item.price | price }}</span>
                    </div>
                </a>
                <div class="flex gap-3 pr-10">
                    @include('rapidez::multiplewishlist.partials.addtocart', ['product' => 'item.item'])
                    <api-request method="delete" :destination="'wishlists/item/' + item.id" :variables="{ wishlistId: {{ $id }} }" v-slot="{ runQuery }" :callback="() => window.Vue.delete($root.custom.currentWishlistData[1], index)">
                        <button class="w-14 h-14 border border-red-600 bg-red-600 text-white hover:bg-white hover:text-red-600 transition rounded-md" @click="runQuery">X</button>
                    </api-request>
                </div>
            </template>
        </div>
    </div>
</div>