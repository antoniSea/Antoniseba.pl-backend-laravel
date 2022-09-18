<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
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
            <table>
              <table className="table-fixed w-full">
                <thead>
                  <tr className="bg-gray-100">
                    <th className="px-4 py-2 w-20">No.</th>
                    <th className="px-4 py-2">Nazwa</th>
                    <th className="px-4 py-2">Opis</th>
                    <th className="px-4 py-2">Akcje</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in items" :key="item.id">
                    <td className="border px-4 py-2">{{ item.id }}.</td>
                    <td className="border px-4 py-2">{{ item.title }}</td>
                    <td className="border px-4 py-2">{{ item.desctiption }}</td>
                    <td className="border px-4 py-2">
                      <Link
                        tabIndex="1"
                        className="px-4 py-2 text-sm text-white bg-blue-500 rounded"
                        :href="route('portfolio-items.edit', { id: item.id })"
                      >
                        Edit
                      </Link>
                      <button
                        tabIndex="-1"
                        type="button"
                        className="mx-1 px-4 py-2 text-sm text-white bg-red-500 rounded"
                        @click="deleteTask(item.id)"
                      >
                        Delete
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <Link
                tabIndex="1"
                className="px-4 py-2 text-sm text-white bg-green-500 rounded mt-8"
                :href="route('portfolio-items.create')"
              >
                Nowy przedmiot w portfolio
              </Link>
            </table>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
export default {
  props: {
    items: Object,
  },
  methods: {
    deleteTask(id) {
      this.$inertia.delete(route("portfolio-items.delete", { id: id }));
    },
  },
};
</script>
