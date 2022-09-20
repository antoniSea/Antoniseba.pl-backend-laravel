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
            <table className="table-fixed w-full">
              <thead>
                <tr className="bg-gray-100">
                  <th className="px-4 py-2 w-20">No.</th>
                  <th className="px-4 py-2">Email</th>
                  <th className="px-4 py-2">Imię i nazwisko</th>
                  <th className="px-4 py-2">Opis</th>
                  <th className="px-4 py-2">Akcje</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="message in messages" :key="message.id">
                  <td className="border px-4 py-2">{{ message.id }}.</td>
                  <td className="border px-4 py-2">{{ message.email }}</td>
                  <td className="border px-4 py-2">{{ message.name }}</td>
                  <td className="border px-4 py-2">
                    {{ message.message }}
                  </td>
                  <td className="border px-4 py-2">
                    <Link
                      tabIndex="1"
                      className="px-4 py-2 text-sm text-white bg-blue-500 rounded"
                      :href="route('messages.show', { id: message.id })"
                    >
                      Edit
                    </Link>
                    <button
                      tabIndex="-1"
                      type="button"
                      className="mx-1 px-4 py-2 text-sm text-white bg-red-500 rounded"
                      @click="deleteMessage(message.id)"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
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
    messages: Object,
  },
  methods: {
    deleteMessage (id) {
      this.$inertia.delete(route('messages.delete', {'id': id}))
    }
  }
};
</script>