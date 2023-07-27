<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Form from '@/Components/Form.vue';
import InputError from '@/Components/FormFields/InputError.vue';
import InputLabel from '@/Components/FormFields/InputLabel.vue';
import SuccessButton from '@/Components/Buttons/SuccessButton.vue';
import TextInput from '@/Components/FormFields/TextInput.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import FieldsGroup from "@/Components/FormFields/FieldsGroup.vue";
import DialogModal from "@/Components/Modals/DialogModal.vue";

defineProps({ errors: Object });

const showNewProductModal = ref(false);

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
  <AppLayout title="New Shipment" v-slot="{ isDarkMode }">
    <Form>
      <template v-slot:fields>
        <FieldsGroup>
          <div class="flex flex-col w-full">
            <InputLabel for="product_id" value="Product" />
            <TextInput
                id="product_id"
                v-model="form.product_id"
                type="text"
                class="block w-full mt-1"
                autofocus
                readonly
            />
            <InputError :message="form.errors.product_id" class="mt-2" />
            <span class="mt-2 text-sm text-black dark:text-white">
              {{ $t("Can't find product you're looking for?") }}

              <span class="text-emerald-600 hover:text-emerald-500 cursor-pointer" @click.prevent="showNewProductModal = true">
                {{ $t('Click here to add new product.') }}
              </span>
            </span>
          </div>
        </FieldsGroup>

        <FieldsGroup>
          <div class="flex flex-col w-full">
            <InputLabel for="scheduled_date" value="Sheduled date" />
            <VueDatePicker id="scheduled_date" v-model="form.scheduled_date" :dark="isDarkMode"></VueDatePicker>
          </div>
        </FieldsGroup>
      </template>

      <template #buttons>
        <SuccessButton type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          {{ $t('Create') }}
        </SuccessButton>
      </template>
    </Form>

    <DialogModal :show="showNewProductModal" :closeable="true" @close="showNewProductModal = false">
      <template #title>
        {{ $t('Add new product') }}
      </template>

      <template #content>
        gggh
      </template>
    </DialogModal>
  </AppLayout>
</template>
