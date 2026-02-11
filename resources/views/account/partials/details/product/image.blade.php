<template v-if="wishlistItem.product.thumbnail">
    <td class="w-20 !px-0 max-md:w-16">
        <img
            v-if="wishlistItem.product.thumbnail"
            class="object-contain h-16 w-20 shrink-0"
            :alt="wishlistItem.product.name"
            :src="`/storage/{{ config('rapidez.store') }}/resizes/200/magento/catalog/product${wishlistItem.product.thumbnail}.webp`"
        >
        <x-rapidez::no-image v-else="" />
    </td>
</template>
