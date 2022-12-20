<div v-if="data">
    <p class="font-bold">@{{ data[0].title }}</p>
    <p>@{{ data[0].description }}</p>
    <div class="flex flex-col">
        <listing v-cloak>
            <div slot-scope="{ loaded, filters, sortOptions, reactiveFilters }">
                <reactive-base
                    :app="config.es_prefix + '_products_' + config.store"
                    :url="config.es_url"
                    v-if="loaded"
                >
                    <reactive-list
                        id="products"
                        component-id="products"
                        data-field="sku.keyword"
                        list-class="flex flex-wrap mt-5 -mx-1 overflow-hidden"
                        :inner-class="{
                            button: '!bg-primary disabled:!bg-secondary',
                        }"
                        :default-query="function() { return { query: { terms: { 'sku.keyword': data[1].map(e => e.sku) } } } }"
                    >
                        <div slot="renderResultStats"></div>
                        <div slot="render" slot-scope="{ data, loading }" v-if="!loading">
                            <div v-for="item in data" class="rounded-md odd:bg-gray-200 flex items-center justify-between p-4">
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
                                    @include('rapidez::multiplewishlist.partials.addtocart', ['product' => 'item'])
                                    <api-request method="delete" :destination="'wishlists/item/' + 3" :variables="{ wishlistId: {{ $id }} }" v-slot="{ runQuery }">
                                        <button class="w-14 h-14 border border-red-600 bg-red-600 text-white hover:bg-white hover:text-red-600 transition rounded-md" @click="runQuery">X</button>
                                    </api-request>
                                </div>
                            </div>
                        </div>
                    </reactive-list>
                </reactive-base>
            </div>
        </listing>
    </div>
</div>