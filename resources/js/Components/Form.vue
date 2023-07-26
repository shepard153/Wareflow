<script setup>
defineEmits(['submitted']);
</script>

<template>
  <form @submit.prevent="$emit('submitted')" class="max-w-3xl mx-auto py-10 sm:px-6 lg:px-8">
    <slot name="info"></slot>

    <slot name="fields"></slot>

    <slot name="buttons"></slot>
  </form>
</template>