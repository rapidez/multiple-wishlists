<div v-if="data">
    <p class="font-bold">@{{ data[0].title }}</p>
    <p>@{{ data[0].description }}</p>
    <div class="flex flex-col">
        <div v-for="(item, index) in data[1]" class="odd:bg-gray-200">
            
        </div>
    </div>
</div>