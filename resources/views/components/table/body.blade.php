<tbody class="divide-y">
    <tr {{ $attributes->merge(['class' => 'flex flex-wrap items-center gap-y-5 py-5 [&>*]:px-2 md:table-row md:[&>*]:py-5 md:[&>*]:px-1.5'])}}>
        {{ $slot }}
    </tr>
</tbody>