<script setup>
import { computed, watchEffect, toRefs } from "vue";
import { useForm } from '@inertiajs/vue3';
import Form from '@/Components/Form.vue';
import InputError from '@/Components/FormFields/InputError.vue';
import InputLabel from '@/Components/FormFields/InputLabel.vue';
import SuccessButton from '@/Components/Buttons/SuccessButton.vue';
import TextInput from '@/Components/FormFields/TextInput.vue';
import Checkbox from '@/Components/FormFields/Checkbox.vue';
import Select from '@/Components/FormFields/Select.vue';

const props = defineProps({
  categories: Object,
  selectedCategory: Object,
  errors: Object
});

const { selectedCategory } = toRefs(props);

const emit = defineEmits(['close']);

const submitDisabled = computed(() => {
  return form.processing
      || form.name == null
      || form.name.length < 4
      || (form.is_subcategory && form.parent_id == null);
});

const form = useForm({
  name: null,
  is_subcategory: false,
  parent_id: null,
});

watchEffect(() => {
  if (props.selectedCategory) {
    form.name = props.selectedCategory.name;
    form.is_subcategory = props.selectedCategory.parent_id != null;
    form.parent_id = props.selectedCategory.parent_id;
  }
});

const create = () => {
  form.post(route('product_categories.store'), {
    preserveScroll: true,
    onSuccess: () => emit('close')
  });
};
</script>

<template>
    <Form @submitted="create" :classes="'w-full space-y-4'">
      <template v-slot:fields>
        <div class="flex flex-col w-full">
          <InputLabel for="product_id" value="Product Category name" />
          <TextInput
              id="name"
              v-model="form.name"
              type="text"
              class="block w-full mt-1"
              autofocus
          />
          <InputError :message="form.errors.name" class="mt-2" />
        </div>

        <div class="flex items-center space-x-2 w-full">
          <Checkbox id="isSubcategory" v-model="form.is_subcategory" value="is_subcategory" />
          <InputLabel for="isSubcategory" value="Is subcategory?" />
        </div>

        <div v-show="form.is_subcategory" class="mt-flex flex-col w-full">
          <InputLabel for="parent_id" value="Select parent category" />
          <Select
              id="parent_id"
              v-model="form.parent_id"
              :options="categories"
              class="block w-full mt-1"
              autofocus
          />
          <InputError :message="form.errors.parent_id" class="mt-2" />
        </div>
      </template>

      <template #buttons>
        <SuccessButton type="submit" :class="{ 'opacity-25': form.processing }" :disabled="submitDisabled">
          {{ $t('Create') }}
        </SuccessButton>
      </template>
    </Form>
</template>
