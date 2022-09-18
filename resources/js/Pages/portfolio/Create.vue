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
              <div class="text-center">
                <div role="alert" class="m-4" v-if="errors.title">
                  <div
                    class="bg-red-500 text-white font-bold rounded-t px-4 py-2"
                  >
                    Uwaga, wystąpiły problemy!
                  </div>
                  <div
                    class="
                      border border-t-0 border-red-400
                      rounded-b
                      bg-red-100
                      px-4
                      py-3
                      text-red-700
                    "
                  >
                    <p>{{ errors.title }}</p>
                  </div>
                </div>

                <input
                  type="text"
                  class="w-96 rounded"
                  v-model="form.title"
                  placeholder="Tytuł"
                />

                <div role="alert" class="m-4" v-if="errors.description">
                  <div
                    class="bg-red-500 text-white font-bold rounded-t px-4 py-2"
                  >
                    Uwaga, wystąpiły problemy!
                  </div>
                  <div
                    class="
                      border border-t-0 border-red-400
                      rounded-b
                      bg-red-100
                      px-4
                      py-3
                      text-red-700
                    "
                  >
                    <p>{{ errors.description }}</p>
                  </div>
                </div>

                <textarea
                  class="w-96 mt-4 rounded"
                  v-model="form.description"
                  placeholder="opis"
                >
                </textarea>

                <div role="alert" class="m-4" v-if="errors.typeSelected">
                  <div
                    class="bg-red-500 text-white font-bold rounded-t px-4 py-2"
                  >
                    Uwaga, wystąpiły problemy!
                  </div>
                  <div
                    class="
                      border border-t-0 border-red-400
                      rounded-b
                      bg-red-100
                      px-4
                      py-3
                      text-red-700
                    "
                  >
                    <p>{{ errors.typeSelected }}</p>
                  </div>
                </div>

                <select class="w-96 mt-4 rounded" v-model="form.typeSelected">
                  <option selected="true" disabled="disabled" value="">-- Wybierz typ --</option>
                  <option
                    v-for="type in portfolioTypes"
                    :key="type.id"
                    :value="type.id"
                  >
                    {{ type.name }}
                  </option>
                </select>

                <div role="alert" class="m-4" v-if="errors.photo">
                  <div
                    class="bg-red-500 text-white font-bold rounded-t px-4 py-2"
                  >
                    Uwaga, wystąpiły problemy!
                  </div>
                  <div
                    class="
                      border border-t-0 border-red-400
                      rounded-b
                      bg-red-100
                      px-4
                      py-3
                      text-red-700
                    "
                  >
                    <p>{{ errors.photo }}</p>
                  </div>
                </div>

                <div class="mt-4">
                  <input
                    type="file"
                    class="w-96 "
                    @input="form.photo = $event.target.files[0]"
                  />
                </div>

                <div>
                  <button
                    class="mt-6 bg-green-500 px-4 py-2 rounded"
                    :class="{ 'opacity-25': form.processing }"
                    role="submit"
                  >
                    Dodaj
                  </button>
                </div>
              </div>
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
    portfolioTypes: Object,
    errors: Object,
  },
  data() {
    return {
      form: this.$inertia.form({
        title: "",
        description: "",
        typeSelected: "",
        photo: "",
      }),
    };
  },
  methods: {
    submit() {
      this.form.post(this.route("portfolio-items.store"));
    },
  },
};
</script>

<style scoped>
.w-96 {
  width: 96%;
}
</style>