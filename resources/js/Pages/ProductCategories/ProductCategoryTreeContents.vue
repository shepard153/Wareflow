<script setup>
import { Link } from "@inertiajs/vue3";
import { useStore } from 'vuex';
import ProductCategoryTree from './ProductCategoryTree.vue';

defineProps({
  category: Object,
});

const store = useStore();

const deleteProductCategory = (category) => {
  store.dispatch('deleteProductCategory', { category });
}
</script>

<template>
  <div v-for="child in category">
    <div class="flex justify-between items-center py-2 px-3 bg-zinc-200/90 dark:bg-zinc-800/50">
      <span class="hover:text-emerald-400 cursor-pointer">
        <Link :href="route('product_categories.show', child.id)">
          {{ child.name }}
        </Link>
      </span>

      <div class="flex space-x-2">
        <button
            class="w-fit px-3 py-1 text-white hover:text-white hover:no-underline bg-indigo-600 hover:bg-indigo-500 rounded-md"
            @click="editProductCategory(child.id)">
          {{ $t('Edit') }}
        </button>

        <button
            class="w-fit px-3 py-1 text-white hover:text-white hover:no-underline bg-red-500 hover:bg-red-600 rounded-md"
            @click="deleteProductCategory(child)"
        >
          {{ $t('Delete') }}
        </button>
      </div>
    </div>
    <!-- ToDo: Proper styling -->
    <div v-if="child && child.children && child.children !== 0" class="ml-4">
      <ProductCategoryTree :productCategories="child.children"/>
    </div>
  </div>
</template>