<template>
    <div class="
            bg-white
            dark:bg-gray-800 dark:text-white
            shadow-xl
            sm:rounded-lg
          ">
        <div class="
              h-12
              border-b border-gray-200
              dark:border-gray-500
              px-2
              flex
              justify-between
              items-center
            " v-if="$slots.header">
            <slot name="header"></slot>
        </div>
        <div>
            <slot />
        </div>
    </div>
</template>
