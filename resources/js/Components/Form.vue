<script setup>
defineEmits(['submitted']);

defineProps({
  classes: {
    type: String,
    default: 'max-w-3xl mx-auto py-10 sm:px-6 lg:px-8'
  }
})
</script>

<template>
  <form @submit.prevent="$emit('submitted')" :class="classes">
    <slot name="info"></slot>

    <slot name="fields"></slot>

    <slot name="buttons"></slot>
  </form>
</template>