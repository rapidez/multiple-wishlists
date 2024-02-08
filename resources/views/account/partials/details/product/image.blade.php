<td v-if="item.thumbnail" class="w-20 !px-0 max-md:w-16">
    <img
        v-if="item.image"
        class="object-contain h-16 w-20 shrink-0"
        :alt="item.name"
        :src="`/storage/{{ config('rapidez.store') }}/resizes/200/magento/catalog/product${item.thumbnail}.webp`"
    >
    <x-rapidez::no-image v-else />
</td>