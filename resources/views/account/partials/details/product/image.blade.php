<template v-if="product.thumbnail">
    <td class="w-20 !px-0 max-md:w-16">
        <img
            v-if="product.thumbnail"
            class="object-contain h-16 w-20 shrink-0"
            :alt="product.name"
            :src="`/storage/{{ config('rapidez.store') }}/resizes/200/magento/catalog/product${product.thumbnail}.webp`"
        >
        <x-rapidez::no-image v-else />
    </td>
</template>
