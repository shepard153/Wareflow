<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import AppLayout from '@/Layouts/AppLayout.vue';
import ConfirmationModal from "@/Components/Modals/ConfirmationModal.vue";
import DialogModal from "@/Components/Modals/DialogModal.vue";
import DangerButton from '@/Components/Buttons/DangerButton.vue';
import SecondaryButton from '@/Components/Buttons/SecondaryButton.vue';
import SuccessButton from '@/Components/Buttons/SuccessButton.vue';
import ProductsList from '@/Pages/Products/ProductsList.vue';
import ProductForm from './Products/ProductForm.vue';

defineProps({
  products: Object,
})

const selectedProduct = ref(null);
const confirmationModalShow = ref(false);

const dialogModalShow = ref(false);

const deleteProduct = (product) => {
  selectedProduct.value = product;
  confirmationModalShow.value = true;
}

const deleteConfirmed = () => {
  router.delete(route('products.delete', {
    'id': selectedProduct.value.id
  }), {
    preserveScroll: true,
    onSuccess: () => {
      confirmationModalShow.value = false
    }
  });
}
</script>

<template>
  <!-- ToDo: Products table w/ pagination -->
  <!-- ToDo: Show/Update -->

  <AppLayout title="Products">
    <div class="bg-white dark:bg-gray-800 shadow">
      <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <SuccessButton @click="dialogModalShow = true">
          {{ $t('Create') }}
        </SuccessButton>
      </div>
    </div>

    <div v-if="products.length > 0">
      <ProductsList :products="products" @deleteProduct="deleteProduct"/>
    </div>

    <div v-else class="flex flex-col max-w-3xl justify-center space-y-8 mx-auto py-12 text-center text-2xl">
      {{ $t('No products found.') }}
    </div>

    <DialogModal :show="dialogModalShow" @close="dialogModalShow = false">
      <template #title>
        {{ $t('Create new product') }}
      </template>

      <template #content>
        <Suspense>
          <ProductForm @close="dialogModalShow = false"/>

          <template #fallback>
            Loading...
          </template>
        </Suspense>
      </template>
    </DialogModal>

    <ConfirmationModal :show="confirmationModalShow" @close="confirmationModalShow = false">
      <template #title>
        {{ $t('Deletion warning!') }}
      </template>

      <template #content>
        {{ $t("You're about to delete :productName. Are you sure you want to delete it?", { 'productName': selectedProduct.name }) }}
      </template>

      <template #footer>
        <form @submit.prevent="deleteConfirmed" class="space-x-2">
          <SecondaryButton @click="confirmationModalShow = false">
            {{ $t('Abort') }}
          </SecondaryButton>

          <DangerButton :type="'submit'">
            {{ $t('Confirm delete') }}
          </DangerButton>
        </form>
      </template>
    </ConfirmationModal>
  </AppLayout>
</template>