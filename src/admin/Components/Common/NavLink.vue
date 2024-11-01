<template>
    <router-link :to="path"
        class="flex items-center py-2 text-base font-normal text-gray-900  hover:text-brand-blue"
        :class="{'disabled': disabled}">
        <span class="flex-1 ml-3 whitespace-nowrap">{{ text }}</span>
    </router-link>
</template>
<script setup>
const props = defineProps({
  path: String,
  text: String,
  disabled: Boolean
})
</script>