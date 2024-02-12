<script>
import { useShare } from '@vueuse/core'
import { wishlists, create, remove, update, addItem, removeItem } from './stores/useWishlists'
import { refresh as refreshCart } from 'Vendor/rapidez/core/resources/js/stores/useCart'
import { mask as cartMask } from 'Vendor/rapidez/core/resources/js/stores/useMask'

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
            let response = await axios({
                method: 'GET',
                url: window.url('/api/wishlists/shared/' + this.sharedId),
                headers: { Store: window.config.store_code },
            })

            this.sharedWishlist = response.data
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
            for (let i = 0; i < this.wishlist.items.length; i++) {
                await this.addToCart(this.wishlist.items[i])
            }

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
            }).catch();
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
