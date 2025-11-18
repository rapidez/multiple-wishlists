<td class="max-sm:w-56 sm:flex-1">
    <div class="flex flex-col items-start">
        <a :href="wishlistItem.product.url" class="font-medium">@{{ wishlistItem.product.name }}</a>
        <span v-if="wishlistItem.category" class="text-muted text-sm">@{{ wishlistItem.category }}</span>
        <span v-if="!wishlistItem.product.in_stock" class="text-sm text">@lang('Not in stock')</span>
    </div>
</td>
