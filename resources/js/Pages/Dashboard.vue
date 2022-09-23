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
            <form @submit.prevent="submit">
              <input type="file" @input="form.photo = $event.target.files[0]" />
              <button>Wyślij</button>
            </form>

            <table className="table-fixed w-full">
              <thead>
                <tr className="bg-gray-100">
                  <th className="px-4 py-2 w-20">No.</th>
                  <th className="px-4 py-2">Nazwa pliku</th>
                  <th className="px-4 py-2">Miniaturka</th>
                  <th className="px-4 py-2">Akcje</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="video in videos" :key="video.id">
                  <td className="border px-4 py-2">{{ video.id }}.</td>
                  <td className="border px-4 py-2">{{ video.name }}</td>
                  <td className="border px-4 py-2">
                    <img :src="video.path_thumbnail" style="width: 800px; width: 400px" v-if="video.progress_thumbnail == 100">
                  </td>
                  <td className="border px-4 py-2">
                    <Link
                      tabIndex="1"
                      className="px-4 py-2 text-sm text-white bg-blue-500 rounded"
                      :href="route('video-processing', {'id': video.id})"
                    >
                      Edit
                    </Link>
                    <button
                      tabIndex="-1"
                      type="button"
                      className="mx-1 px-4 py-2 text-sm text-white bg-red-500 rounded"
                      @click="deleteVideo(video.id)"
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
import Swal from 'sweetalert2'

export default {
  props: {
    videos: {
      type: Array
    },
  },
  data() {
    return {
      form: this.$inertia.form({
        photo: null,
      }),
    };
  },
  mounted() {
    // if (this.video.progress == 0) {
    //   setTimeout(this.refresh, 200);
    // }
  },
  methods: {
    submit() {
      this.form.post(route("test"));
    },
    deleteVideo (id) {
      Swal.fire({
        title: 'Czy jesteś pewien?',
        text: "Tej akcji nie da się odwrócić!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Tak, usuń!',
        cancelButtonColor: 'anulluj'
      }).then((result) => {
        if (result.isConfirmed) {
          this.$inertia.delete(route('video.delete', {'id': id}))
        }
      })
    }
  },
};
</script>
