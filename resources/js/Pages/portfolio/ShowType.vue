<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
</script>

<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <form @submit.prevent="submit">
              <input
                type="text"
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
                v-model="form.name"
                placeholder="Tytuł"
              />
              <button
                class="mt-6 bg-green-500 px-4 py-2 rounded"
                :class="{ 'opacity-25': form.processing }"
                role="submit"
              >
                edytuj
              </button>
              <button
                @click.prevent="deleteItem"
                class="mt-6 bg-red-500 px-4 py-2 rounded mx-2"
              >
                Usuń
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
  props: {
    type: Object,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: this.type.name,
      }),
    };
  },
  methods: {
    submit() {
      this.form.put(route("portfolio-type.update", {'id': this.type.id}));
    },
    deleteItem() {
      this.$inertia.delete(route("portfolio-type.delete", {'id': this.type.id}));
    },
  },
};
</script>