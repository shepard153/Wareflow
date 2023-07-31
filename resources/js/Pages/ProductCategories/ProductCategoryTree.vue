<script setup>
import ProductCategoryTreeContents from "./ProductCategoryTreeContents.vue";

defineProps({
  productCategories: Object,
});
</script>

<template>
  <ProductCategoryTreeContents :category="productCategories"/>
</template>