<script>
import { removeItem, updateItem } from './stores/useWishlists'

export default {
    props: {
        wishlistId: Number,
        data: Array,
        item: Object,
    },

    data() {
        return {
            quantity: null,
        }
    },

    render() {
        return this.$scopedSlots.default(this)
    },

    mounted() {
        this.quantity = this.item.qty;
    },

    methods: {
        remove() {
            removeItem(this.wishlistId, this.item.wishlist_item_id)
        }
    },

    computed: {
        product() {
            return this.data.find(e => e.entity_id == this.item.product_id)
        },

        categories() {
            if (!this.product?.categories?.length) {
                return null
            }

            return this.product.categories.map(
                categories => categories.split(' /// ').map(
                    category => category.split('::').at(-1)
                )
            )
        },

        category() {
            return this.categories?.at(-1)?.at(-1) ?? null;
        }
    },

    watch: {
        quantity(newVal, oldVal) {
            if(oldVal === null || oldVal === newVal) {
                return
            }

            if(newVal < 0) {
                this.quantity = 0
                return
            }

            updateItem(this.wishlistId, this.item.wishlist_item_id, { qty: this.quantity })
        }
    }
}
</script>
