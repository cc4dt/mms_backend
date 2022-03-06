<template>
<div class="shadow-lg rounded-2xl w-36 p-4 bg-white dark:bg-gray-800">
    <div class="flex items-center">
    <span v-if="icon" class="bg-green-500 p-1 rounded-full relative">
        <li :class="icon" class="text-white h-4 w-4"></li>
    </span>
    <p class="text-md text-gray-700 dark:text-gray-50 ml-2">
        {{ title }}
    </p>
    </div>
    <div class="flex flex-col justify-between">
    <div class="space-y-1 my-4">
        <p class="text-gray-800 text-2xl text-left dark:text-white font-bold">
        {{ count }}
        </p>

        <p v-if="total" class="text-md text-gray-700 dark:text-gray-50 ml-4">
        of {{ total }}
        </p>
    </div>
    <div class="relative w-28 h-2 bg-gray-200 rounded">
        <div
        class="absolute top-0 h-2 left-0 rounded bg-green-500"
        :style="'width: ' + (percent ?? 0) + '%'"
        ></div>
    </div>
    </div>
</div>
</template>

<script>
export default {
  props: ["icon", "title", "count", "total", "percent"],
};
</script>

<style>
</style>