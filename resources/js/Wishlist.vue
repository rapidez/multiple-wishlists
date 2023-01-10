<script>
export default {
    props: {
        wishlistId: {
            type: Number,
            default: 0
        },
        sharedId: String
    },

    data() {
        return {
            wishlists: [],
            wishlist: null
        }
    },

    watch: {
        wishlists: {
            handler: function() {
                localStorage.wishlists = JSON.stringify(this.wishlists);
            }, deep: true
        }
    },

    mounted() {
        if(this.sharedId) {
            this.fetchShared();
        } else {
            this.fetchWishlists();
        }
    },

    methods: {
        async fetchWishlists() {
            if (!this.$root.user) {
                return;
            }

            if (!localStorage.wishlists) {
                await this.$root.apiRequest('get', '/api/wishlists/all', {}, function(response) {
                    localStorage.wishlists = JSON.stringify(response.data);
                })
            }

            this.wishlists = JSON.parse(localStorage.wishlists);

            if(this.wishlistId) {
                this.wishlist = this.wishlists.find(e => e.id == this.wishlistId);
            }
        },

        async fetchShared() {
            this.wishlist = await this.$root.apiRequest('get', '/api/wishlists/shared/' + this.sharedId);
        },

        getWishlist(id) {
            var ret = this.wishlists.find(e => e.id == id);
            if(!ret) return null;
            if(!ret.title) ret.title = "";
            if(!ret.description) ret.description = "";
            if(!ret.share) ret.share = false;
            return ret;
        },

        findItem(wishlist, productId) {
            return wishlist.items.find(e => e.product_id == productId);
        },

        async toggleItem(wishlist, productId, qty = 1, description = '', redirect) {
            var item = this.findItem(wishlist, productId);
            if (item) {
                this.removeItem(wishlist, item.wishlist_item_id, redirect);
            } else {
                this.addItem(wishlist, productId, qty, description, redirect);
            }
        },

        async checkMake(id, title, callback) {
            var ret = this.getWishlist(id);
            if(!ret) {
                ret = await this.addWishlist(title);
            }

            if(callback) {
                await callback(ret);
            }

            return ret;
        },

        async addItem(wishlist, productId, qty = 1, description = '', redirect) {
            await this.$root.apiRequest('post', '/api/wishlists/item/', {
                wishlist_id: wishlist.id,
                product_id: productId,
                description: description,
                qty: qty
            }, function (response) {
                wishlist.items.push(response.data);
            });

            if(redirect) {
                Turbolinks.visit(redirect);
            }
        },

        async removeItem(wishlist, productId, redirect) {
            var wishlistItemId = this.findItem(wishlist, productId).wishlist_item_id;
            await this.$root.apiRequest('delete', '/api/wishlists/item/' + wishlistItemId, {}, function (response) {
                window.Vue.delete(wishlist.items, wishlist.items.findIndex(e => e.wishlist_item_id == wishlistItemId));
            });

            if(redirect) {
                Turbolinks.visit(redirect);
            }
        },

        async editItem(wishlist, productId, variables, redirect) {
            var wishlistItemId = this.findItem(wishlist, productId).wishlist_item_id;
            await this.$root.apiRequest('patch', '/api/wishlists/item/' + wishlistItemId, variables, function (response) {
                var item = wishlist.items.find(e => e.wishlist_item_id == wishlistItemId);
                item.description = response.data.description;
                item.qty = response.data.qty;
            })

            if(redirect) {
                Turbolinks.visit(redirect);
            }
        },


        async addWishlist(title, redirect) {
            var wishlists = this.wishlists;
            var ret = null;
            await this.$root.apiRequest('post', '/api/wishlists/', {
                title: title
            }, function (response) {
                response.data.items = [];
                wishlists.push(response.data);
                ret = response.data;
            });

            if(redirect) {
                Turbolinks.visit(redirect);
            } else {
                return ret;
            }
        },

        async editWishlist(wishlist, title, description, shared, redirect) {
            console.log([title, description, shared]);
            await this.$root.apiRequest('patch', '/api/wishlists/' + wishlist.id, {
                title: title,
                description: description ?? '',
                shared: shared
            }, function (response) {
                wishlist.title = response.data.title;
                wishlist.description = response.data.description;
                wishlist.shared = response.data.shared;
            });

            if(redirect) {
                Turbolinks.visit(redirect);
            }
        },

        async removeWishlist(wishlist, redirect) {
            var wishlists = this.wishlists;
            await this.$root.apiRequest('delete', '/api/wishlists/' + wishlist.id, {}, function (response) {
                window.Vue.delete(wishlists, wishlists.findIndex(e => e.id == wishlist.id));
            })

            if(redirect) {
                Turbolinks.visit(redirect);
            }
        },
    },

    render() {
        return this.$scopedSlots.default({
            wishlists: this.wishlists,
            wishlist: this.wishlist,

            addItem: this.addItem,
            removeItem: this.removeItem,
            editItem: this.editItem,
            toggleItem: this.toggleItem,

            findItem: this.findItem,

            getWishlist: this.getWishlist,
            addWishlist: this.addWishlist,
            removeWishlist: this.removeWishlist,
            editWishlist: this.editWishlist,
            tempWishlist: JSON.parse(JSON.stringify(this.wishlist)),

            checkMake: this.checkMake
        })
    },
}
</script>
