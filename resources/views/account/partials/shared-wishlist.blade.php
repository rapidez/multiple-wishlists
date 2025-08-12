<a v-if="wishlist.shared" :href="'{{ route('wishlist.shared', 'replaceme') }}'.replace('replaceme', wishlist.sharing_token)" class="text-muted text-sm hover:underline">
    (@lang('shared'))
</a>
