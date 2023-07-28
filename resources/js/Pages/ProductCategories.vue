<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SuccessButton from '@/Components/Buttons/SuccessButton.vue';
import ConfirmationModal from "@/Components/Modals/ConfirmationModal.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";
import DialogModal from "@/Components/Modals/DialogModal.vue";
import ProductCategoryForm from './ProductCategories/ProductCategoryForm.vue';

defineProps({
  productCategories: Object
});

const confirmationModalShow = ref(false);
const dialogModalShow = ref(false);
const deleteCategory = ref(null);

const deleteProductCategory = (category) => {
  confirmationModalShow.value = true;
  deleteCategory.value = category;
}

const deleteConfirmed = () => {
  confirmationModalShow.value = false;

  router.delete(route('product_categories.delete', { 'id': deleteCategory.value.id }));
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

        <div class="flex justify-between items-center py-2 px-3 bg-zinc-200/90 dark:bg-zinc-800/50"
             v-for="productCategory in productCategories"
             :key="productCategory.id"
        >
          <span class="hover:text-emerald-400 cursor-pointer">
            <Link :href="route('product_categories.show', productCategory.id)">
              {{ productCategory.name }}
            </Link>
          </span>

          <div class="flex space-x-2">
            <button class="w-fit px-3 py-1 text-white hover:text-white hover:no-underline bg-indigo-600 hover:bg-indigo-500 rounded-md">
              {{ $t('Edit') }}
            </button>

            <button class="w-fit px-3 py-1 text-white hover:text-white hover:no-underline bg-red-500 hover:bg-red-600 rounded-md"
                    @click="deleteProductCategory(productCategory)"
            >
              {{ $t('Delete') }}
            </button>
          </div>
        </div>
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

    <ConfirmationModal :show="confirmationModalShow" @close="confirmationModalShow = false">
      <template #title>
        {{ $t('Deletion warning!') }}
      </template>

      <template #content>
        {{ $t("You're about to delete :categoryName category. Are you sure you want to delete it?", { 'categoryName': deleteCategory.name }) }}
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