import { useLocalStorage } from "@vueuse/core"
import { computed, watch } from "vue"
import { token } from 'Vendor/rapidez/core/resources/js/stores/useUser'

export const wishlistStorage = useLocalStorage('wishlists', [])
let isRefreshing = false
let hasFetched = false

export const refresh = async function () {
    if (!token.value) {
        clear()
        return true
    }

    if (isRefreshing) {
        console.debug('Refresh canceled, request already in progress...')
        return
    }

    try {
        isRefreshing = true
        var response = await axios({
            method: 'GET',
            url: window.url('/api/wishlists'),
            headers: {
                Authorization: `Bearer ${token.value}`,
                Store: window.config.store_code,
            },
        }).finally(() => {
            isRefreshing = false
        })
    } catch (error) {
        console.error(error)
        Notify(window.config.translations.errors.wrong, 'error')

        return false
    }

    if (response === undefined || !response.data) {
        return false
    }

    hasFetched = true
    wishlistStorage.value = response.data

    return true
}

export const clear = async function () {
    wishlistStorage.value = []
    hasFetched = false
}

export const wishlists = computed({
    get() {
        if (!hasFetched && Object.keys(wishlistStorage.value).length === 0) {
            refresh()
        }

        return wishlistStorage.value
    },
    set(value) {
        wishlistStorage.value = value
    }
})

watch(token, refresh)

export default () => wishlists

export const create = async function (title) {
    try {
        let response = await axios({
            method: 'POST',
            url: window.url('/api/wishlists'),
            headers: {
                Authorization: `Bearer ${token.value}`,
                Store: window.config.store_code,
            },
            data: {
                title: title
            },
        })

        let data = {
            items: [],
            ...response.data,
            shared: false,
        }
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
        await axios({
            method: 'DELETE',
            url: window.url('/api/wishlists/' + id),
            headers: {
                Authorization: `Bearer ${token.value}`,
                Store: window.config.store_code,
            },
        })

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
            let response = await axios({
                method: 'PATCH',
                url: window.url('/api/wishlists/' + id),
                headers: {
                    Authorization: `Bearer ${token.value}`,
                    Store: window.config.store_code,
                },
                data: {
                    title: data.title,
                    description: data.description,
                    shared: data.shared,
                },
            })

            let wishlist = wishlists.value.find(e => e.id == id)
            wishlist.title = response.data.title
            wishlist.description = response.data.description
            wishlist.shared = response.data.shared
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
        let response = await axios({
            method: 'POST',
            url: window.url('/api/wishlists/item'),
            headers: {
                Authorization: `Bearer ${token.value}`,
                Store: window.config.store_code,
            },
            data: {
                wishlist_id: id,
                product_id: productId,
            },
        })

        let wishlist = wishlists.value.find(e => e.id == id)
        wishlist.items.push(response.data)
    } catch (error) {
        console.log(error)
        Notify(window.config.translations.errors.wrong, 'error')

        return false
    }
}

export const removeItem = async function (id, itemId) {
    try {
        await axios({
            method: 'DELETE',
            url: window.url('/api/wishlists/item/' + itemId),
            headers: {
                Authorization: `Bearer ${token.value}`,
                Store: window.config.store_code,
            },
        })

        let wishlist = wishlists.value.find(e => e.id == id)
        let index = wishlist.items.findIndex(e => e.wishlist_item_id == itemId)
        wishlist.items.splice(index, 1)
    } catch (error) {
        console.log(error)
        Notify(window.config.translations.errors.wrong, 'error')

        return false
    }
}

export const updateItem = async function (id, itemId, data) {
    try {
        if ('description' in data || 'qty' in data) {
            let response = await axios({
                method: 'PATCH',
                url: window.url('/api/wishlists/item/' + itemId),
                headers: {
                    Authorization: `Bearer ${token.value}`,
                    Store: window.config.store_code,
                },
                data: {
                    description: data.description,
                    qty: data.qty,
                },
            })

            let wishlist = wishlists.value.find(e => e.id == id)
            let item = wishlist.items.find(e => e.wishlist_item_id == itemId)
            item.description = response.data.description
            item.qty = response.data.qty
        }

        return true
    } catch (error) {
        console.log(error)
        Notify(window.config.translations.errors.wrong, 'error')

        return false
    }
}
