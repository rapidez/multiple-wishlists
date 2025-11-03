<td class="w-40">
    <x-rapidez::quantity
        v-model="wishlistItem.quantity"
        v-bind:min="0"
        v-bind:max="9999"
        v-bind:step="(wishlistItem.product.qty_increments ?? 1)"
    />
</td>
