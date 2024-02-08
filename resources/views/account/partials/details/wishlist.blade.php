@props(['editable' => true])

<div v-if="wishlist">
    <div class="flex justify-between">
        <div class="relative flex w-full justify-between mb-4 max-lg:items-end">
            @include('rapidez-mw::account.partials.details.title')
            @include('rapidez-mw::account.partials.details.edit-button')
        </div>
    </div>
    @include('rapidez-mw::account.partials.details.description')
    <listing v-cloak>
        <div slot-scope="{ loaded }">
            <reactive-base :app="config.es_prefix + '_products_' + config.store" :url="config.es_url" v-if="loaded">
                <reactive-list id="products" component-id="products" data-field="entity_id" :default-query="function() { return { query: { terms: { 'entity_id': wishlist.items.map(e => e.product_id) } } } }">
                    <div slot="renderResultStats"></div>
                    <div slot="renderNoResults">@lang('This wishlist is empty.')</div>
                    <div slot="render" slot-scope="{ data }" class="flex flex-col">
                        <table v-if="data" class="font-sans">
                            <x-rapidez-mw::table.header>
                                <th class="max-md:text-start">
                                    <p class="whitespace-nowrap">
                                        @{{ data.length }}
                                        <template v-if="data.length > 1">
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
                            <x-rapidez-mw::table.body v-for="(item, index) in data" v-bind:key="item.entity_id">
                                <template v-if="findItem(wishlist, item.entity_id)">
                                    @include('rapidez-mw::account.partials.details.product.image')
                                    @include('rapidez-mw::account.partials.details.product.name')
                                    @include('rapidez-mw::account.partials.details.product.remove')
                                    @include('rapidez-mw::account.partials.details.product.quantity')
                                    @include('rapidez-mw::account.partials.details.product.price')
                                </template>
                                <td v-else class="text-center w-full italic text-ct-inactive p-5">
                                    @lang('Deleted')
                                </td>
                            </x-rapidez-mw::table.body>
                        </table>
                        <div class="flex rounded bg-ct-inactive-100 p-3 md:justify-end">
                            @include('rapidez-mw::account.partials.details.addtocart')
                        </div>
                    </div>
                </reactive-list>
            </reactive-base>
        </div>
    </listing>
</div>
