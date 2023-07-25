<script setup>
import {computed} from "vue";
import { Link } from '@inertiajs/vue3';

defineProps({
  type: {
    type: String,
    default: 'button',
  },
  href: String,
  as: {
    type: String,
    default: 'button'
  },
});

const classes = computed(() => {
  return 'inline-flex items-center justify-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500 active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 cursor-pointer transition ease-in-out duration-150';
});
</script>

<template>
  <div>
    <button v-if="as == 'button'" :type="type" :class="classes">
      <slot/>
    </button>

    <Link v-else :href="href" :class="classes">
      <slot/>
    </Link>
  </div>
</template>
