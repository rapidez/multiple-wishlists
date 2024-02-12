@if($editable)
    <td>
        <button @click="removeItem(wishlist, item.entity_id)" class="hover:opacity-75 max-md:ml-auto">
            <x-heroicon-s-heart class="w-5 h-5 text-ct-wishlist" />
        </button>
    </td>
@endif
