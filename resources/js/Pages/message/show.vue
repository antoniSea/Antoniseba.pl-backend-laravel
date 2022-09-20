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
            Imię i nazwisko klienta: {{ message.name }}
            <br />
            Email klienta:
            <a :href="`mailto: ${message.email}`"> {{ message.email }} </a>
            <br />
            Opis: {{ message.message }}

            <div v-if="!replyMode">
              <button
                class="px-4 py-2 bg-blue-500 rounded text-white block mt-4"
                @click="replyMode = true"
              >
                Odpisz
              </button>
            </div>

            <div v-else>
              <form @submit.prevent="submit">
                <input
                  class="
                    mt-8
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
                  type="text"
                  placeholder="Tytuł"
                  v-model="form.title"
                />

                <textarea
                  class="
                    mt-4
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
                  placeholder="Opis"
                  type="text"
                  v-model="form.description"
                />

                <button
                  class="mt-6 bg-green-500 px-4 py-2 rounded text-white"
                  :class="{ 'opacity-25': form.processing }"
                  role="submit"
                >
                  Dodaj
                </button>

                <button
                  class="mt-6 bg-red-500 px-4 py-2 rounded text-white mx-2"
                  @click.prevent="replyMode = false"
                >
                  Zamknij
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
export default {
  props: {
    message: Object,
  },
  data() {
    return {
      replyMode: false,
      form: this.$inertia.form({
        title: "",
        description: "",
      }),
    };
  },
  methods: {
    submit() {
      this.form.post();
    },
  },
};
</script>