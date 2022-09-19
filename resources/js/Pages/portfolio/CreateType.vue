<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
</script>


<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Nowy Typ portfolio
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <form @submit.prevent="submit">
              <div class="mb-4">
                <label
                  class="block text-gray-700 text-sm font-bold mb-2"
                  for="username"
                >
                  Nazwa
                </label>
                <input
                  class="
                    shadow
                    appearance-none
                    border
                    rounded
                    w-full
                    py-2
                    px-3
                    text-gray-700
                    leading-tight
                    focus:outline-none focus:shadow-outline
                  "
                  id="Nazwa"
                  type="text"
                  placeholder="Nazwa"
                  v-model="form.name"
                />
              </div>
              <button
                class="mt-4 bg-green-500 px-4 py-2 rounded"
                role="submit"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Dodaj
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
export default {
  data() {
    return {
      form: this.$inertia.form({
        name: "",
      }),
    };
  },
  methods: {
    submit () {
      this.form.post(route('portfolio-type.store'))
    }
  }
};
</script>
