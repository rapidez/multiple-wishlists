@props(['editable' => true])

<div v-if="wishlist">
    <div class="flex justify-between">
        <div class="relative flex w-full justify-between mb-4 max-lg:items-end">
            @include('rapidez-mw::account.partials.details.title')
            @includeWhen($editable, 'rapidez-mw::account.partials.details.edit-button')
        </div>
    </div>
    @include('rapidez-mw::account.partials.details.description')
    <listing v-cloak>
        <div slot-scope="{ loaded }">
            <reactive-base :app="config.es_prefix + '_products_' + config.store" :url="config.es_url" v-if="loaded">
                <reactive-list id="products" component-id="products" data-field="entity_id" :default-query="function() { return { query: { terms: { 'entity_id': wishlist.items.map(e => e.product_id) } } } }">
                    <div slot="renderResultStats"></div>
                    <div slot="renderNoResults"></div>
                    <div slot="loader"></div>
                    <div slot="render" slot-scope="{ data, loading }" class="flex flex-col">
                        <template v-if="wishlist?.items?.length">
                            <template v-if="loading">
                                <x-heroicon-o-arrow-path class="animate-spin size-6"/>
                            </template>
                            <table v-if="data" class="font-sans">
                                <x-rapidez-mw::table.header>
                                    <th class="max-md:text-start">
                                        <p class="whitespace-nowrap">
                                            @{{ wishlist.items.length }}
                                            <template v-if="wishlist.items.length != 1">
                                                @lang('articles')
                                            </template>
                                            <template v-else>
                                                @lang('article')
                                            </template>
                                        </p>
                                    </th>
                                    <th class="!pl-0 max-md:hidden"></th>
                                    @if($editable)
                                        <th class="!pl-0 max-md:hidden"></th>
                                    @endif
                                    <th class="!text-center max-md:hidden">@lang('Amount')</th>
                                    <th class="!pl-0 max-md:hidden"></th>
                                </x-rapidez-mw::table.header>
                                <tbody>
                                    <template v-for="(item, index) in wishlist.items">
                                        <wishlist-item :data="data" :item="item" :wishlist-id="wishlist.id">
                                            <div
                                                class="border-b flex flex-wrap items-center gap-y-5 py-5 *:px-2 last:border-none md:align-middle md:table-row md:*:py-5 md:*:px-1.5"
                                                v-bind:class="{'opacity-70': product && !product.in_stock }"
                                                slot-scope="{ _renderProxy: self, product, remove, category }"
                                                v-bind:key="item.id"
                                            >
                                                <template v-if="product">
                                                    @include('rapidez-mw::account.partials.details.product.image')
                                                    @include('rapidez-mw::account.partials.details.product.name')
                                                    @include('rapidez-mw::account.partials.details.product.remove')
                                                    @include('rapidez-mw::account.partials.details.product.quantity')
                                                    @include('rapidez-mw::account.partials.details.product.price')
                                                </template>
                                            </div>
                                        </wishlist-item>
                                    </template>
                                </tbody>
                            </table>
                            <div class="flex rounded bg-ct-inactive-100 p-3 md:justify-end">
                                @include('rapidez-mw::account.partials.details.addtocart')
                            </div>
                        </template>
                        <template v-else>
                            @lang('You have no items in your wishlist')
                        </template>
                    </div>
                </reactive-list>
            </reactive-base>
        </div>
    </listing>
</div>
