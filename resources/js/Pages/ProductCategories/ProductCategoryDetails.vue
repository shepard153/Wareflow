<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  categoryProducts: Object,
  productCategory: Object
});
</script>

<template>
  <AppLayout title="Product Categories">
    <div v-if="categoryProducts.items">
      <div v-for="product in categoryProducts.items">
        {{ product }}
      </div>
    </div>

    <div v-else class="flex flex-col max-w-3xl justify-center space-y-8 mx-auto py-12 text-center text-2xl">
      {{ $t('No products in this category') }}
    </div>
  </AppLayout>
</template>