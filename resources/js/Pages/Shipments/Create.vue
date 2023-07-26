<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Form from '@/Components/Form.vue';
import InputError from '@/Components/FormFields/InputError.vue';
import InputLabel from '@/Components/FormFields/InputLabel.vue';
import SuccessButton from '@/Components/Buttons/SuccessButton.vue';
import TextInput from '@/Components/FormFields/TextInput.vue';
import VueDatePicker from '@vuepic/vue-datepicker';

defineProps({
  errors: Object,
  isDarkMode: Boolean
});

const form = useForm({
  product_id: null,
  contact_id: null,
  warehouse_id: null,
  shipment_type: null,
  quantity: null,
  description: null,
  reference: null,
  tracking_number: null,
  shipment_date: null,
  scheduled_date: null,
});

const createShipment = () => {
  form.post(route('shipments.store'), {
    preserveScroll: true,
  });
};
</script>

<template>
  <AppLayout title="New Shipment">
    <Form>
      <template #fields>
        <div class="flex flex-col w-full">
          <InputLabel for="name" value="Product" />
          <TextInput
              id="name"
              v-model="form.product_id"
              type="text"
              class="block w-full mt-1"
              autofocus
              readonly
          />
          <InputError :message="form.errors.product_id" class="mt-2" />
          <VueDatePicker v-model="form.scheduled_date" :dark="isDarkMode"></VueDatePicker>
        </div>
      </template>

      <template #buttons>
        <SuccessButton type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Create
        </SuccessButton>
      </template>
    </Form>
  </AppLayout>
</template>
