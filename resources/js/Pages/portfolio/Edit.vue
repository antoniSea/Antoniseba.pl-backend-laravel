<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
</script>

<template>
  <Head :title="`Przedmiot: ${Item.id}`" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Przedmiot: {{ Item.id }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div>
              <img :src="Item.main_photo" alt="" />
            </div>
            <div v-if="!editMode">
              <h2 class="font-bold text-4xl mt-4">
                Przedmiot: {{ Item.title }}
              </h2>
              <p>
                Opis: {{ Item.desctiption }}
                <br />
                Typ: {{ Item.Type.name }}
                <br />
                Stworzono: {{ Item.created_at }}
                <br />
                Ostatnia edycja: {{ Item.updated_at }}
                <br />
              </p>
              <button
                @click="editMode = true"
                class="bg-green-500 rounded py-2 px-4 mt-4"
              >
                Edytuj
              </button>
            </div>
            <div v-else>
              <form @submit.prevent="submit">
                <input
                  type="text"
                  v-model="form.title"
                  class="rounded mt-4 w-100"
                  placeholder="nazwa"
                  role="button"
                />
                <br />
                <input
                  v-model="form.desctiption"
                  class="rounded mt-4 w-100"
                  placeholder="nazwa"
                  role="button"
                  type="text"
                />
                <br />

                <select class="w-100 mt-4 rounded" v-model="form.typeSelected">
                  <option
                    v-for="type in portfolioTypes"
                    :key="type.id"
                    :value="type.id"
                    :selected="Item.Type.id === type.id"
                  >
                    {{ type.name }}
                  </option>
                </select>

                <div>
                  <input
                    type="file"
                    class="w-50 mt-4"
                    @input="form.photo = $event.target.files[0]"
                  />
                </div>
                <br />
                <button
                  class="bg-green-500 rounded py-2 px-4 mt-4 mx-4 float-left"
                  role="submit"
                  :class="{ 'opacity-25': form.processing }"
                >
                  Edytuj
                </button>
              </form>
              <button
                @click="editMode = false"
                class="bg-red-500 rounded py-2 px-4 mt-4"
              >
                Zamknij edycję
              </button>
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
    Item: Object,
    portfolioTypes: Object,
  },
  data() {
    return {
      editMode: false,
      form: this.$inertia.form({
        title: this.Item.title,
        description: this.Item.desctiption,
        typeSelected: "",
        photo: "",
      }),
    };
  },
  methods: {
    submit() {
      this.form.put(route("portfolio-items.update", { id: this.Item.id }));
    },
  },
};
</script>

<style>
.w-100 {
  width: 50%;
}
</style>