<td class="max-sm:w-56 sm:flex-1">
    <div class="flex flex-col items-start">
        <a :href="product.url" class="font-medium text-base">@{{ product.name }}</a>
        <span v-if="category" class="text-muted text-sm">@{{ category }}</span>
        <span v-if="!product.in_stock" class="text-sm text">@lang('Not in stock')</span>
    </div>
</td>
