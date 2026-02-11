<script>
import { useShare } from '@vueuse/core'
import { wishlists, create, remove, update, addItem, removeItem } from './stores/useWishlists'
import { mask as cartMask } from 'Vendor/rapidez/core/resources/js/stores/useMask'
import wishlistItem from './WishlistItem.vue'

export default {
    components: [
        wishlistItem
    ],
    props: {
        wishlistId: {
            type: Number,
            default: 0
        },
        sharedId: String,
    },

    emits: ['update:modelValue'],

    setup() {
        const { share, isSupported } = useShare()
        return {
            shareFn: share,
            isSupported,
        }
    },

    data() {
        return {
            adding: false,
            added: false,
            editing: null,
            sharedWishlist: null,
            wishlists: wishlists
        }
    },

    methods: {
        isWishlisted(productId) {
            console.log(wishlists, this.wishlists)
            return this.wishlists && Array.isArray(this.wishlists) && this.wishlists.some(e => this.findItem(e, productId))
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
            return this.wishlists?.find(e => e.id == id);
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

            try {
                let response = await window.magentoGraphQL(
                    `mutation ($cartId: String!, $cartItems: [CartItemInput!]!) {
                        addProductsToCart(cartId: $cartId, cartItems: $cartItems)
                        { cart { ...cart } user_errors { code message } }
                    }
                    ` + config.fragments.cart,
                    {
                        cartId: cartMask.value,
                        cartItems: this.wishlist.items.map((item) => ({
                            sku: item.product.sku,
                            quantity: item.qty,
                        })),
                    },
                )

                await this.updateCart({}, response)

                this.added = true
                setTimeout(() => this.added = false, 3000)
            } catch(error) {
                Notify(error.message, 'error')
            }

            this.adding = false
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
        return this.$slots.default(this)
    },
    mounted() {
        if(this.sharedId) {
            this.fetchShared()
        }
    },
}
</script>
