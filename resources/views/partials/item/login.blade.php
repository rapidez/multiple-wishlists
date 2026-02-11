<template v-if="!window.app.config.globalProperties.loggedIn.value">
    @lang('You must log in to add a product to your order list.') <a href="/login" class="text-primary underline underline-offset-3">@lang('login')</a>
</template>