<script setup>
import { router } from "@inertiajs/vue3";
import { useStore } from 'vuex';
import AppLayout from '@/Layouts/AppLayout.vue';
import SuccessButton from '@/Components/Buttons/SuccessButton.vue';
import ConfirmationModal from "@/Components/Modals/ConfirmationModal.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";
import DialogModal from "@/Components/Modals/DialogModal.vue";
import ProductCategoryForm from './ProductCategories/ProductCategoryForm.vue';
import ProductCategoryTree from "@/Pages/ProductCategories/ProductCategoryTree.vue";

defineProps({
  productCategories: Object,
  productCategoryTree: Object
});

const store = useStore();
const selectedProductCategory = () => store.state.productCategoryStore.selectedProductCategory;

const dialogModalShow = (state = null) => {
  if (state === false) {
    store.dispatch('toggleDialogModal', false);
  } else if (state === true) {
    store.dispatch('toggleDialogModal', true);
  } else {
    return store.state.productCategoryStore.dialogModalShow;
  }
};

const confirmationModalShow = (state = null) => {
  if (state === false) {
    store.dispatch('toggleConfirmationModal', false);
  } else if (state === true) {
    store.dispatch('toggleConfirmationModal', true);
  } else {
    return store.state.productCategoryStore.confirmationModalShow;
  }
};

const deleteConfirmed = () => {
  store.commit('toggleConfirmationModal', false);

  router.delete(route('product_categories.delete', { 'id': selectedProductCategory().id }));
}
</script>

<template>
  <AppLayout title="Product Categories">
    <div class="bg-white dark:bg-gray-800 shadow">
      <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <SuccessButton @click="dialogModalShow(true)">
          {{ $t('Create') }}
        </SuccessButton>
      </div>
    </div>
    <div class="flex flex-col max-w-3xl justify-center space-y-8 mx-auto py-12">
      <div class="flex flex-col">
        <div class="py-2 px-3 font-semibold border-y">
          {{ $t('Category name') }}
        </div>

        <ProductCategoryTree :productCategories="productCategoryTree"/>
      </div>
    </div>

    <DialogModal :show="dialogModalShow()" @close="dialogModalShow(false)">
      <template #title>
        {{ selectedProductCategory().id ? $t('Update product category') : $t('Create new product category') }}
      </template>

      <template #content>
        <ProductCategoryForm :categories="productCategories" :selectedCategory="selectedProductCategory()" @close="dialogModalShow(false)"/>
      </template>
    </DialogModal>

    <ConfirmationModal :show="confirmationModalShow()" @close="confirmationModalShow(false)">
      <template #title>
        {{ $t('Deletion warning!') }}
      </template>

      <template #content>
        {{ $t("You're about to delete :categoryName category. Are you sure you want to delete it?", { 'categoryName': selectedProductCategory().name }) }}
      </template>

      <template #footer>
        <form @submit.prevent="deleteConfirmed" class="space-x-2">
          <SecondaryButton @click="confirmationModalShow(false)">
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