<script setup>
defineEmits(['submitted']);
</script>

<template>
  <form @submit.prevent="$emit('submitted')" class="max-w-3xl mx-auto py-10 sm:px-6 lg:px-8">
    <slot name="info"></slot>

    <div class="flex items-center px-4 py-3 bg-gray-50 dark:bg-gray-800 sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
      <slot name="fields"></slot>
    </div>

    <slot name="buttons"></slot>
  </form>
</template>