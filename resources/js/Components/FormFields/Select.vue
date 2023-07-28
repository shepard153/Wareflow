<script setup>
const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  options: {
    type: [Array, Object],
    default: null
  },
  modelValue: {
    type: String,
    default: null,
  },
});

</script>

<template>
  <select
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
  >
    <option v-for="option in options"
            :key="option.id ? option.id : option.name"
            :value="option.id ? option.id : option.name"
    >
      {{ option.name }}
    </option>
  </select>
</template>
