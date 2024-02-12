@if($editable)
    <td>
        <button @click="remove" class="hover:opacity-75 max-md:ml-auto">
            <x-heroicon-s-heart class="w-5 h-5 text-ct-error" />
        </button>
    </td>
@endif
