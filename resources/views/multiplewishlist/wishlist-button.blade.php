<toggler v-slot="{ isOpen, toggle, close }" v-cloak>
    <div class="absolute right-0 top-0">
        <button class="p-2" @click="toggle">
            <x-heroicon-s-heart class="w-6 h-6" v-if="!isOpen"/>
            <x-heroicon-o-heart class="w-6 h-6" v-else/>
        </button>
        <div v-show="isOpen" v-if="$root.user" v-cloak class="absolute right-0 border rounded-md bg-gray-100 p-5 w-64">
            <api-request method="get" immediate destination="wishlists/all" v-slot="{ runQuery, data, contains }">
                <div class="flex flex-col gap-2">
                    <div v-for="item in data" :key="item.id" :set="contains = item.items.findIndex(e => e.product_id == {{ $product->id }})" class="flex gap-2 w-full items-center justify-end">
                        <div class="overflow-ellipsis overflow-hidden whitespace-nowrap">
                            @{{ item.title }}
                        </div>
                        <div class="border border-primary rounded-md w-fit inline-block self-start" :class="contains > -1 ? 'text-white bg-primary' : 'text-primary'">
                            <api-request
                                :method="contains > -1 ? 'delete' : 'post'"
                                :destination="'wishlists/item' + (contains > -1 ? ('/' + item.items[contains].wishlist_item_id) : '')"
                                :variables="{wishlistId: item.id, productId: {{ $product->id }}, qty: 1}"
                                v-slot="{ runQuery, data }"
                                :callback="(response) => {
                                    var id = item.items.findIndex(e => e.product_id == {{ $product->id }});
                                    if(id > -1) {
                                        window.Vue.delete(item.items, id);
                                    }
                                    else {
                                        item.items.push(response.data);
                                    }
                                }">
                                <button class="p-2" @click="runQuery"><x-heroicon-s-heart class="w-6 h-6"/></button>
                            </api-request>
                        </div>
                    </div>
                </div>
            </api-request>
        </div>
    </div>
</toggler>