<script setup>
defineProps({
  modelValue: String,
});

defineEmits(['update:modelValue']);

</script>

<template>
  <textarea @input="$emit('update:modelValue', $event.target.value)"
            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            :value="modelValue"
  >
    {{ modelValue }}
  </textarea>
</template>