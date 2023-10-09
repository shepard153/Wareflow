<script setup>
import { computed } from 'vue';
import {Link} from '@inertiajs/vue3';

const props = defineProps({
  href: String,
  as: String,
  active: Boolean,
});

const classes = computed(() => {
  return props.active ? 'font-medium text-gray-900 dark:text-gray-100 border-l-4 border-indigo-400 dark:border-indigo-600' : '';
});

</script>

<template>
  <div>
    <button v-if="as == 'button'" type="submit"
            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
            :class="classes"
    >
      <slot/>
    </button>

    <a v-else-if="as =='a'" :href="href"
       class="block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
       :class="classes"
    >
      <slot/>
    </a>

    <Link v-else :href="href"
          class="block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
          :class="classes"
    >
      <slot/>
    </Link>
  </div>
</template>
