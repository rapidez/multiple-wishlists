<td>
    <div class="flex justify-center">
        <x-rapidez::quantity
            v-model="wishlistItem.quantity"
            v-bind:min="0"
            v-bind:step="(wishlistItem.product.qty_increments ?? 1)"
        />
    </div>
</td>
