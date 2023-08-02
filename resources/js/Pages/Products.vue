<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import DialogModal from "@/Components/Modals/DialogModal.vue";
import SuccessButton from '@/Components/Buttons/SuccessButton.vue';
import ProductsList from '@/Pages/Products/ProductsList.vue';

defineProps({
  products: Object,
})

const dialogModalShow = ref(false);
</script>

<template>
  <!-- ToDo: Products table w/ pagination -->
  <!-- ToDo: Create/Show/Update/Delete -->

  <AppLayout title="Products">
    <div class="bg-white dark:bg-gray-800 shadow">
      <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <SuccessButton @click="dialogModalShow = true">
          {{ $t('Create') }}
        </SuccessButton>
      </div>
    </div>

    <div v-if="products.items">
      <ProductsList :products="products" />
    </div>

    <div v-else class="flex flex-col max-w-3xl justify-center space-y-8 mx-auto py-12 text-center text-2xl">
      {{ $t('No products found.') }}
    </div>

    <DialogModal :show="dialogModalShow" @close="dialogModalShow = false">
      <template #title>
        {{ $t('Create new product') }}
      </template>

      <template #content>

      </template>
    </DialogModal>
  </AppLayout>
</template>