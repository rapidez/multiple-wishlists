@if($editable)
    <td>
        <button @click="remove" class="hover:opacity-75 max-md:ml-auto">
            <x-heroicon-s-heart class="size-5 text" />
        </button>
    </td>
@endif
