<script setup>
import { ref } from 'vue';
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
import productCategoryStore from "@/stores/product-category-store.js";

defineProps({
  productCategories: Object,
  productCategoryTree: Object
});

const store = useStore();

const dialogModalShow = ref(false);

const showProductCategory = () => {
  dialogModalShow.value = true;
}

const confirmationModalShow = (state) => {
  if (state === false) {
    store.commit('toggleConfirmationModal', false);
  } else {
    return store.state.productCategoryStore.confirmationModalShow;
  }
};

const deleteProductCategory = () => {
  return store.state.productCategoryStore.deleteProductCategory.category;
};

const deleteConfirmed = () => {
  store.commit('toggleConfirmationModal', false);

  router.delete(route('product_categories.delete', { 'id': deleteProductCategory().id }));
}
</script>

<template>
  <AppLayout title="Product Categories">
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
          {{ $t('Category name') }}
        </div>

        <ProductCategoryTree :productCategories="productCategoryTree"/>
      </div>
    </div>

    <DialogModal :show="dialogModalShow" @close="dialogModalShow = false">
      <template #title>
        {{ $t('Create new product category') }}
      </template>

      <template #content>
        <ProductCategoryForm :categories="productCategories" @close="dialogModalShow = false"/>
      </template>
    </DialogModal>

    <ConfirmationModal :show="confirmationModalShow(true)" @close="confirmationModalShow(false)">
      <template #title>
        {{ $t('Deletion warning!') }}
      </template>

      <template #content>
        {{ $t("You're about to delete :categoryName category. Are you sure you want to delete it?", { 'categoryName': deleteProductCategory().name }) }}
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