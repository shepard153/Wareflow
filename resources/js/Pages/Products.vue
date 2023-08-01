<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import DialogModal from "@/Components/Modals/DialogModal.vue";
import SuccessButton from '@/Components/Buttons/SuccessButton.vue';

defineProps({
  products: Object,
})

const dialogModalShow = ref(false);
</script>

<template>
  <!-- ToDo: Products table w/ pagination -->
  <!-- ToDo: No products message -->
  <!-- ToDo: Create/Show/Update/Delete -->

  <AppLayout title="Products">
    <div class="bg-white dark:bg-gray-800 shadow">
      <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <SuccessButton @click="dialogModalShow = true">
          {{ $t('Create') }}
        </SuccessButton>
      </div>
    </div>

    <div class="flex flex-col max-w-3xl justify-center space-y-8 mx-auto py-12">
      <div class="flex flex-col">
        <div class="py-2 px-3 font-semibold border-y">
          {{ $t('Product name') }}
        </div>

      </div>
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