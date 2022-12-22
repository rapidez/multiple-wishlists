import Vue from 'vue'
import apirequest from './APIRequest.vue'
Vue.component('api-request', apirequest)

document.addEventListener('turbolinks:load', (event) => {
    Vue.set(window.app.custom, 'currentWishlistData', [])
})