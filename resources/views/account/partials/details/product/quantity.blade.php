<td class="w-40">
    <div class="flex w-20 overflow-hidden rounded border">
        <button
            @disabled(!$editable)
            v-bind:disabled="self.quantity <= 0"
            class="flex-1 bg-muted transition hover:bg-opacity-80"
            v-on:click="self.quantity--"
        >-</button>
        <input
            class="h-10 w-2/5 border-none px-0 text-center text-sm [appearance:textfield] focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
            name="qty"
            type="number"
            {{ $attributes }}
            @disabled(!$editable)
            v-model="self.quantity"
            min="0"
            v-bind:step="product.qty_increments"
        />
        <button
            @disabled(!$editable)
            class="flex-1 bg-muted transition hover:bg-opacity-80"
            v-on:click="self.quantity++"
        >+</button>
    </div>
</td>
