import { useLocalStorage } from "@vueuse/core"
import { computed, ref, watch } from "vue"
import { token } from 'Vendor/rapidez/core/resources/js/stores/useUser'
import { on } from 'Vendor/rapidez/core/resources/js/polyfills/emit'

export const wishlistStorage = useLocalStorage('wishlists', [])
const isRefreshing = ref(false)
const hasFetched = ref(false)

export const refresh = async function () {
    if (!token.value) {
        clear()
        return true
    }

    if (isRefreshing.value) {
        console.debug('Refresh canceled, request already in progress...')
        return
    }

    isRefreshing.value = true
    try {
        wishlistStorage.value = (await window.rapidezAPI('GET', 'wishlists', {})) || []
        hasFetched.value = true
    } catch (error) {
        console.error(error)
        Notify(window.config.translations.errors.wrong, 'error')
    }
    isRefreshing.value = false
}

export const clear = async function () {
    wishlistStorage.value = []
    hasFetched.value = false
}

export const wishlists = computed(() => {
    if (!hasFetched.value && wishlistStorage.value.length === 0) {
        refresh()
    }

    return wishlistStorage.value
})

watch(token, refresh)

on('logged-out', clear, {autoremove: false});

export default () => wishlists

export const create = async function (title) {
    try {
        let response = await window.rapidezAPI('POST', 'wishlists', { title: title })

        let data = { items: [], ...response }
        wishlists.value.push(data)

        return data
    } catch (error) {
        console.error(error)
        Notify(window.config.translations.errors.wrong, 'error')

        return null
    }
}

export const remove = async function (id) {
    try {
        await window.rapidezAPI('DELETE', 'wishlists/' + id, {})

        let index = wishlists.value.findIndex(e => e.id == id)
        wishlists.value.splice(index, 1)

        return true
    } catch (error) {
        console.error(error)
        Notify(window.config.translations.errors.wrong, 'error')

        return false
    }
}

export const update = async function (id, data) {
    try {
        if ('title' in data || 'description' in data || 'shared' in data) {
            let fetchData = {
                title: data.title,
                description: data.description,
                shared: data.shared,
            }
            let response = await window.rapidezAPI('PATCH', 'wishlists/' + id, fetchData)

            let wishlist = wishlists.value.find(e => e.id == id)
            wishlist.title = response.title
            wishlist.description = response.description
            wishlist.shared = response.shared

            wishlist.updated_at = new Date().toISOString()
        }

        return true
    } catch (error) {
        console.log(error)
        Notify(window.config.translations.errors.wrong, 'error')

        return false
    }
}

export const addItem = async function (id, productId) {
    try {
        let fetchData = {
            wishlist_id: id,
            product_id: productId,
        }
        let response = await window.rapidezAPI('POST', 'wishlists/item', fetchData)

        let wishlist = wishlists.value.find(e => e.id == id)
        wishlist.items.push(response)

        wishlist.updated_at = new Date().toISOString()

        return true
    } catch (error) {
        console.log(error)
        Notify(window.config.translations.errors.wrong, 'error')

        return false
    }
}

export const removeItem = async function (id, itemId) {
    try {
        await window.rapidezAPI('DELETE', 'wishlists/item/' + itemId, {})

        let wishlist = wishlists.value.find(e => e.id == id)
        let index = wishlist.items.findIndex(e => e.wishlist_item_id == itemId)
        wishlist.items.splice(index, 1)

        wishlist.updated_at = new Date().toISOString()
    } catch (error) {
        console.log(error)
        Notify(window.config.translations.errors.wrong, 'error')

        return false
    }
}

export const updateItem = async function (id, itemId, data) {
    try {
        if ('description' in data || 'qty' in data) {
            let fetchData = {
                description: data.description,
                qty: data.qty,
            }
            let response = await window.rapidezAPI('PATCH', 'wishlists/item/' + itemId, fetchData)

            let wishlist = wishlists.value.find(e => e.id == id)
            let item = wishlist.items.find(e => e.wishlist_item_id == itemId)
            item.description = response.description
            item.qty = response.qty

            wishlist.updated_at = new Date().toISOString()
        }

        return true
    } catch (error) {
        console.log(error)
        Notify(window.config.translations.errors.wrong, 'error')

        return false
    }
}
