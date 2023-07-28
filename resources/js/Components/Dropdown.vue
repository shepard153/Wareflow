<script setup>
import {computed, onMounted, onUnmounted, ref} from 'vue';

const props = defineProps({
  active: Boolean,
  dropdownClasses: String,
  align: {
    type: String,
    default: 'right',
  },
  width: {
    type: String,
    default: '48',
  },
  contentClasses: {
    type: Array,
    default: () => ['py-1', 'bg-white dark:bg-gray-700'],
  },
});

let open = ref(false);

const closeOnEscape = (e) => {
  if (open.value && e.key === 'Escape') {
    open.value = false;
  }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const widthClass = computed(() => {
  return {
    '48': 'w-48',
  }[props.width.toString()];
});

const alignmentClasses = computed(() => {
  if (props.align === 'left') {
    return 'origin-top-left left-0';
  }

  if (props.align === 'right') {
    return 'origin-top-right right-0';
  }

  return 'origin-top';
});

const activeClasses = computed(() => {
  return props.active ? 'font-medium text-gray-900 dark:text-gray-100 border-b-2 border-indigo-400 dark:border-indigo-600'
      : 'border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-700';
});
</script>

<template>
  <div class="relative" :class="[dropdownClasses, activeClasses]">
    <div @click="open = ! open">
      <slot name="trigger"/>
    </div>

    <!-- Full Screen Dropdown Overlay -->
    <div v-show="open" class="fixed inset-0 z-40" @click="open = false"/>

    <transition
        enter-active-class="transition ease-out duration-200"
        enter-from-class="transform opacity-0 scale-95"
        enter-to-class="transform opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75"
        leave-from-class="transform opacity-100 scale-100"
        leave-to-class="transform opacity-0 scale-95"
    >
      <div
          v-show="open"
          class="absolute z-50 mt-2 rounded-md shadow-lg"
          :class="[widthClass, alignmentClasses]"
          style="display: none;"
          @click="open = false"
      >
        <div class="rounded-md ring-1 ring-black ring-opacity-5" :class="contentClasses">
          <slot name="content"/>
        </div>
      </div>
    </transition>
  </div>
</template>
