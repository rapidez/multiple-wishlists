import axios from 'axios'

import wishlist from './Wishlist.vue'
Vue.component('wishlist', wishlist)

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
    methods: {
        apiRequest: async function(method, url, variables = {}, callback = null, validateStatus = (status) => { return status >= 200 && status < 300 }) {
            try {
                let headers = {}

                if (this.$root.user) {
                    headers['Authorization'] = `Bearer ${localStorage.token}`
                }

                if (window.config.store_code) {
                    headers['Store'] = window.config.store_code
                }

                let response = await axios({
                    method: method,
                    url: url,
                    data: variables,
                    headers: headers,
                    validateStatus: validateStatus,
                })

                if (response.data.errors) {
                    Notify(response.data.errors[0].message, 'error')
                    return
                }

                return callback ? await callback(response) : response.data
            } catch (e) {
                Notify(window.config.translations.errors.wrong, 'warning')
            }
        }
    }
})
