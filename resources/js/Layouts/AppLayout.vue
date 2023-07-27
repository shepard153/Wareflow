<script setup>
import {computed, ref} from 'vue';
import {Head, Link, usePage} from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import Navbar from './Partials/Navbar.vue';

defineProps({
  title: String
});

const page = usePage()
const breadcrumbs = computed(() => page.props.breadcrumbs)
const isDarkMode = ref(window.matchMedia('(prefers-color-scheme: dark)').matches);
</script>

<template>
  <div>
    <Head :title="title"/>

    <Banner/>

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
      <Navbar/>

      <!-- Page Heading/Breadcrumbs -->
      <header class="bg-white dark:bg-gray-800 shadow">
        <div v-if="breadcrumbs" class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
          <span v-for="(page, index) in breadcrumbs"
                :key="page.title"
                class="text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <Link :href="page.url" :class="{ 'font-semibold': page.is_current_page }">
              {{ page.title }}
            </Link>

            <span v-if="breadcrumbs[index + 1]">
              /
            </span>
          </span>
        </div>
      </header>

      <!-- Page Content -->
      <main class="text-gray-800 dark:text-gray-200">
        <slot :isDarkMode="isDarkMode"/>
      </main>
    </div>
  </div>
</template>
