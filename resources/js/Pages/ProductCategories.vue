<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SuccessButton from '@/Components/Buttons/SuccessButton.vue';

defineProps({
  productCategories: Object
})
</script>

<template>
  <AppLayout title="Product Categories">
    <div class="bg-white dark:bg-gray-800 shadow">
      <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <SuccessButton :as="'link'" :href="route('product_categories.create')">
          {{ $t('Create') }}
        </SuccessButton>
      </div>
    </div>
    <div class="py-12">
      <table>
        <tr v-for="productCategory in productCategories">
          <td>{{ productCategory.name }}</td>
        </tr>
      </table>
    </div>
  </AppLayout>
</template>