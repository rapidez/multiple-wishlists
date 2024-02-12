import wishlist from './Wishlist.vue'
import wishlistItem from './WishlistItem.vue'
Vue.component('wishlist', wishlist)
Vue.component('wishlist-item', wishlistItem)

document.addEventListener('turbo:load', (event) => {
    window.app.$on('logout', () => {
        localStorage.removeItem('wishlists')
    });
})

Vue.mixin({
    data() {
        return {
            wishlistsLoading: false
        }
    },
})
