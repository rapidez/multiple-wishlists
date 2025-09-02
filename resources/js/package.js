Vue.component('wishlist', () => import('./Wishlist.vue'))

document.addEventListener('vue:loaded', (event) => {
    window.app.$on('logged-out', () => {
        localStorage.removeItem('wishlists')
    });
})
