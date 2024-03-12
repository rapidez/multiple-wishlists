<script>
import { useShare } from '@vueuse/core'
import { wishlists, create, remove, update, addItem, removeItem } from './stores/useWishlists'
import { refresh as refreshCart } from 'Vendor/rapidez/core/resources/js/stores/useCart'
import { mask as cartMask } from 'Vendor/rapidez/core/resources/js/stores/useMask'

import wishlistItem from './WishlistItem.vue'
Vue.component('wishlist-item', wishlistItem)

export default {
    props: {
        wishlistId: {
            type: Number,
            default: 0
        },
        sharedId: String,
    },

    mounted() {
        if(this.sharedId) {
            this.fetchShared()
        }

        const { share, isSupported } = useShare()
        this.shareFn = share
        this.isSupported = isSupported
    },

    data() {
        return {
            adding: false,
            added: false,
            editing: null,
            sharedWishlist: null,

            shareFn: null,
            isSupported: null,
        }
    },

    methods: {
        isWishlisted(productId) {
            return this.wishlists.some(e => this.findItem(e, productId))
        },

        findItem(wishlist, productId) {
            return wishlist.items.find(e => e.product_id == productId) ?? null
        },

        toggleItem(wishlist, productId) {
            let item = this.findItem(wishlist, productId)
            if (item) {
                removeItem(wishlist.id, item.wishlist_item_id)
            } else {
                addItem(wishlist.id, productId)
            }
        },

        async fetchShared() {
            this.sharedWishlist = await window.rapidezAPI('GET', 'wishlists/shared/' + this.sharedId)
        },

        getWishlist(id) {
            return this.wishlists.find(e => e.id == id);
        },

        addWishlist: create,
        async removeWishlist(id, redirect = false) {
            await remove(id)
            if (redirect) {
                Turbo.visit(window.url('/account/wishlists'))
            }
        },
        update: update,

        async addAllToCart() {
            this.adding = true
            await Promise.allSettled(
                this.wishlist.items.map(
                    (item) => this.addToCart(item)
                )
            )

            await refreshCart()
            this.added = true
            this.adding = false
            setTimeout(() => this.added = false, 3000)
        },

        async addToCart(item) {
            await this.magentoCart('post', 'items', {
                cartItem: {
                    sku: item.product.sku,
                    quote_id: cartMask.value,
                    qty: item.qty,
                }
            }).catch((error) => {
                Notify(error.message, 'error')
            })
        },

        toggleEdit() {
            if (!this.editing) {
                this.editing = {
                    title: this.wishlist.title,
                    description: this.wishlist.description,
                    shared: this.wishlist.shared,
                }
            } else {
                this.editing = null
            }
        },

        save() {
            if (!this.editing || !this.wishlist) {
                return
            }

            update(this.wishlist.id, this.editing)
            this.toggleEdit()
        },

        share() {
            if (!this.isSupported) {
                return
            }

            return this.shareFn(Object.fromEntries(Object.entries({
                title: this.wishlist.title,
                text: this.wishlist.description,
                url: this.shareUrl,
            }).filter(([_, v]) => v)))
        }
    },

    computed: {
        wishlists() {
            return wishlists.value
        },

        wishlist() {
            if (this.wishlistId) {
                return this.getWishlist(this.wishlistId)
            } else if (this.sharedWishlist) {
                return this.sharedWishlist
            }

            return null
        },

        shareUrl() {
            if (!this.wishlist?.shared) {
                return null
            }

            return window.url('/wishlists/shared/' + this.wishlist.sharing_token)
        },
    },

    render() {
        return this.$scopedSlots.default(this)
    },
}
</script>
