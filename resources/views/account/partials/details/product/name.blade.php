<td class="max-sm:w-56 sm:flex-1">
    <div class="flex flex-col items-start">
        <a :href="item.url" class="font-medium text-base">@{{ item.name }}</a>
        <span v-if="item.categories?.length" class="text-ct-inactive text-sm">@{{ item.categories.at(-1).split(' /// ').at(-1).split('::').at(-1) }}</span>
    </div>
</td>