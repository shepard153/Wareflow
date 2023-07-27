<script setup>
import {Head, Link} from '@inertiajs/vue3';
import Login from '@/Pages/Auth/Login.Vue';

defineProps({
  canRegister: Boolean,
  canResetPassword: Boolean
});
</script>

<template>
  <Head title="Welcome"/>

  <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-gray-100 dark:bg-gray-900">

    <img src="images/wareflow-logo.png" alt="Wareflow logo"/>

    <Link v-if="$page.props.auth.user" :href="route('dashboard')"
          class="px-5 py-3 font-semibold text-gray-200 hover:text-white bg-emerald-500 hover:bg-emerald-400 hover:scale-110 transition-all duration-700">
      {{ $t('Go to application') }}
    </Link>

    <template v-else>
      <div class="flex flex-col">
        <Login :canResetPassword="canResetPassword" :canRegister="canRegister"/>
      </div>
    </template>
  </div>
</template>