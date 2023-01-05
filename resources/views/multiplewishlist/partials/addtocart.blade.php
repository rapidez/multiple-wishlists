@props(['qty' => '1', 'product' => 'product'])
<add-to-cart v-if="{{ $product }}.in_stock" v-cloak v-bind:product="{{ $product }}" :default-qty="parseInt({{ $qty }})">
    <div {{ $attributes->merge(['class' => 'flex h-14 w-32 overflow-hidden']) }}
        slot-scope="{ qty, add, adding, added, changeQty }"
    >
        <input type="number" class="w-full" :value="qty" @change="editItem(wishlist, contains(wishlist, item.id).wishlist_item_id, {qty: $event.target.value});changeQty($event)"/>

        <button ref="addToCart" v-on:click="add" dusk="add-to-cart" class="group flex h-full w-full items-center justify-center bg-primary text-white transition border border-primary rounded-md hover:bg-white hover:text-primary">
            <x-heroicon-o-shopping-cart class="h-5 w-5" v-if="!adding && !added" />
            <x-heroicon-o-refresh class="h-5 w-5 animate-spin" v-if="adding" />
            <x-heroicon-o-check class="h-5 w-5" v-if="added" />
        </button>
    </div>
</add-to-cart>
<div v-else>
    <div {{ $attributes->merge(['class' => 'flex h-[52px] w-[106px] overflow-hidden rounded-8 text-inactive-700 text-center items-center']) }}>
        @lang("Out of stock")
    </div>
</div>