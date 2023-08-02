<script setup>
import { computed, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import Form from '@/Components/Form.vue';
import InputLabel from '@/Components/FormFields/InputLabel.vue';
import TextInput from '@/Components/FormFields/TextInput.vue';
import InputError from '@/Components/FormFields/InputError.vue';
import Select from '@/Components/FormFields/Select.vue';
import SuccessButton from '@/Components/Buttons/SuccessButton.vue';
import Textarea from "@/Components/FormFields/Textarea.vue";

const emit = defineEmits(['close']);

const categories = ref([]);

const response = await fetch(route('api.categories.get'), { method: "GET" });

if (response.ok) {
  categories.value = await response.json();
} else {
  console.error("Failed to fetch categories.", response.status);
}

const form = useForm({
  category_id: null,
  name: null,
  description: null,
  sku: null,
  unit_of_measure: null,
});

const submitDisabled = computed(() => {
  return form.processing
      || form.name == null
      || form.name.length < 4
      || form.sku == null
      || form.unit_of_measure == null;
});

const action = () => {
  create();
};

const create = () => {
  form.post(route('products.store'), {
    preserveScroll: true,
    onSuccess: () => emit('close')
  });
};

const update = () => {
  form.patch(route('product_categories.update', { 'id': props.selectedCategory.id }), {
    preserveScroll: true,
    onSuccess: () => emit('close')
  });
};
</script>

<template>
  <Form @submitted="action" :classes="'w-full space-y-4'">
    <template v-slot:fields>
      <div class="mt-flex flex-col w-full">
        <InputLabel for="category_id" value="Select product category" />
        <Select
            id="category_id"
            v-model="form.category_id"
            :options="categories"
            class="block w-full mt-1"
            autofocus
        />
        <InputError :message="form.errors.category_id" class="mt-2" />
      </div>

      <div v-show="form.category_id" class="flex flex-col w-full">
        <InputLabel for="product_id" value="Product name" />
        <TextInput
            id="name"
            v-model="form.name"
            type="text"
            class="block w-full mt-1"
            autofocus
        />
        <InputError :message="form.errors.name" class="mt-2" />
      </div>

      <div v-show="form.name" class="flex flex-col w-full">
        <InputLabel for="description" value="Product description" />
        <Textarea
            id="description"
            v-model="form.description"
            type="textarea"
            class="block w-full mt-1"
            autofocus
        />
        <InputError :message="form.errors.description" class="mt-2" />
      </div>

      <div v-show="form.name" class="flex flex-col w-full">
        <InputLabel for="sku" value="SKU" />
        <TextInput
            id="sku"
            v-model="form.sku"
            type="text"
            class="block w-full mt-1"
            autofocus
        />
        <InputError :message="form.errors.sku" class="mt-2" />
      </div>

      <div v-show="form.sku" class="flex flex-col w-full">
        <InputLabel for="unit_of_measure" value="Unit of measure" />
        <TextInput
            id="unit_of_measure"
            v-model="form.unit_of_measure"
            type="text"
            class="block w-full mt-1"
            autofocus
        />
        <InputError :message="form.errors.unit_of_measure" class="mt-2" />
      </div>
    </template>

    <template #buttons>
      <SuccessButton type="submit" :class="{ 'opacity-25': form.processing }" :disabled="submitDisabled">
        {{ $t('Create') }}
      </SuccessButton>
    </template>
  </Form>
</template>