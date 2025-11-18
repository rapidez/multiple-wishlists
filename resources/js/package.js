import './stores/useWishlists';
import { defineAsyncComponent } from 'vue'

document.addEventListener('vue:loaded', function (event) {
    const vue = event.detail.vue
    vue.component('wishlist', defineAsyncComponent(() => import('./Wishlist.vue')))
    vue.component('wishlist-item', defineAsyncComponent(() => import('./WishlistItem.vue')))
})
