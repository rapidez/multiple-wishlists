<script>
    export default {
        props: {
            method: {
                type: String,
                required: true,
            },
            destination: {
                type: String,
                required: true,
            },
            variables: {
                type: Object,
                default: () => ({}),
            },
            immediate: {
                type: Boolean,
                default: false,
            },
            redirect: {
                type: String,
            },
            check: {
                type: String,
            },
            checkfail: {
                type: String,
            },
            cache: {
                type: String,
            },
            callback: {
                type: Function,
            },
        },

        data: () => ({
            data: null,
            cachePrefix: 'api_',
            running: false
        }),

        render() {
            return this.$scopedSlots.default({
                data: this.data,
                runQuery: this.runQuery,
                running: this.running,
            })
        },

        created() {
            if (!this.getCache() && this.immediate) {
                this.runQuery()
            }
        },

        methods: {
            getCache() {
                let cache = false

                if (cache = localStorage[this.cachePrefix + this.cache]) {
                    this.data = JSON.parse(cache)
                }

                return cache
            },

            async runQuery() {
                this.running = true;
                try {
                    let headers = {}

                    if (this.$root.user) {
                        headers['Authorization'] = `Bearer ${localStorage.token}`
                    }

                    if (window.config.store_code) {
                        headers['Store'] = window.config.store_code
                    }

                    let response = await axios({
                        method: this.method,
                        url:  '/api/' + this.destination,
                        data: this.variables,
                        headers: headers})

                    if (response.data.errors) {
                        if (response.data.errors[0].extensions.category == 'graphql-authorization') {
                            this.logout('/login')
                        } else {
                            Notify(response.data.errors[0].message, 'error')
                        }
                        return
                    }

                    if (this.check) {
                        if (!eval('response.' + this.check)) {
                            Turbolinks.visit(this.checkfail)
                            return
                        }
                    }

                    this.data = this.callback
                        ? await this.callback(response)
                        : response.data

                    if (this.cache) {
                        localStorage[this.cachePrefix + this.cache] = JSON.stringify(this.data)
                    }

                    if (this.redirect) {
                        Turbolinks.visit(this.redirect);
                    }
                } catch (e) {
                    Notify(window.config.translations.errors.wrong, 'warning')
                }
                this.running = false;
            }
        }
    }
</script>
