<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
</script>

<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Typy portfolio
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div
              class="flex justify-content-between mb-6"
              v-for="type in types"
              :key="type.id"
            >
              <div>{{ type.name }}</div>
              <div>
                <Link
                  class="px-4 py-2 bg-blue-500 rounded"
                  :href="route('portfolio-type.show', { id: type.id })"
                  >Edytuj</Link
                >
                <button
                  class="px-4 py-2 bg-red-500 rounded mx-2"
                  @click="deleteItem(type.id)"
                >
                  Usuń
                </button>
              </div>
            </div>
            <Link
              tabIndex="1"
              className="px-4 py-2 text-sm text-white bg-green-500 rounded mt-8"
              :href="route('portfolio-type.create')"
            >
              Nowy typ w portfolio
            </Link>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
export default {
  props: {
    types: Object,
  },
  methods: {
    deleteItem(id) {
      this.$inertia.delete(route("portfolio-type.delete", { id: id }));
    },
  },
};
</script>

<style>
.justify-content-between {
  justify-content: space-between;
}
</style>
