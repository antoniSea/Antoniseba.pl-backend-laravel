<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
</script>

<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Opublikuj wideo
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex">
              <div class="w-400">
                <img :src="video.path_thumbnail" style="width: 800px; width: 400px" v-if="video.progress_thumbnail == 100">

                <video-player ref="videoPlayer"
                  class="vjs-custom-skin"
                  :options="videoOptions"
                  v-if="video.progress == 100"
                />
                  
                <sync-loader :loading="loading" :color="color" class="inline" :size="sm" v-if="video.progress != 100" />
                Progress przesyłania: {{ video.progress }} <br />
                
                <sync-loader v-if="!video.progress_thumbnail == 100" class="inline" :color="color" style="display: inline;" :size="sm" />
                Progress generowania miniaturki: {{ video.progress_thumbnail }}
              </div>
              <div class="w-800">
                
                <form @submit.prevent="submit" >
                  <input
                    class="
                      shadow
                      appearance-none
                      border
                      rounded
                      w-full
                      mx-4
                      text-gray-700
                      leading-tight
                      focus:outline-none focus:shadow-outline
                    "
                    type="text"
                    placeholder="Tytuł"
                    v-model="form.title"
                    @input="syncFormDebounde"
                  />

                  <textarea
                    class="
                      shadow
                      appearance-none
                      border
                      rounded
                      w-full
                      h-32
                      mt-6
                      mx-4
                      text-gray-700
                      leading-tight
                      focus:outline-none focus:shadow-outline
                    "
                    type="text"
                    placeholder="Opis"
                    v-model="form.description"
                    @input="syncFormDebounde"
                  />

                  <input
                    class="
                      shadow
                      appearance-none
                      border
                      rounded
                      w-full
                      mt-6
                      mx-4
                      text-gray-700
                      leading-tight
                      focus:outline-none focus:shadow-outline
                    "
                    type="text"
                    placeholder="tagi"
                    v-model="form.tags"
                    @input="syncFormDebounde"
                  />

                  <div class="flex items-center mt-4 mx-4">
                    <input id="default-checkbox" @input="syncFormDebounde" v-model="form.public" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Czy film ma byc publiczny</label>
                  </div>
                  
                </form>

                <div class="mt-[130px]">
                  <div class="text-green-500 text-center" v-if="isFromSaved">Zapisano!</div>
                  <sync-loader v-if="syncProcessing" :color="color" :size="sm" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import VideoPlayer from "@/Components/VideoPlayer.vue";
import { SyncLoader } from 'vue-spinner/dist/vue-spinner.min.js'
import axios from "axios"
import { debounce } from 'debounce'

export default {
  components: {
    VideoPlayer,
    SyncLoader
  },
  props: {
    video: {
      type: Object,
    },
  },
  data() {
    return {
      videoOptions: {
        autoplay: true,
        controls: true,
        width: "400px",
        height: "200px",
        sources: [
          {
            src: "/storage/" + this.video.name + ".m3u8",
            type: "application/x-mpegURL",
          },
        ],
      },
      video: this.video,
      videoDynamic: this.video,
      form: this.$inertia.form({
        title: this.video.title,
        description: this.video.description,
        tags: this.video.tags,
        public: this.video.public == 0 ? false : true
      }),
      syncProcessing: false,
      isFromSaved: false,
      timeoutId: '',
    };
  },
  mounted() {
    this.refresh();
  },
  methods: {
    refresh() {
      if (this.videoDynamic.progress != 100 || this.videoDynamic.progress_thumbnail != 100) {

        axios.get('/api/video/' + this.video.id).then((response) => {
          this.video = response.data
          this.videoDynamic = response.data
        })
        
        setTimeout(this.refresh, 2000);
      }
    },
    syncForm () {
      clearTimeout(this.timeoutId)

      this.syncProcessing = true
      this.isFromSaved = false

      let postdata = {
        title: this.form.title,
        description: this.form.description,
        tags: this.form.tags,
        public: this.form.public
      }

      postdata.public = !postdata.public

      axios.put('/api/video/' + this.video.id, postdata).then(() => {
        this.syncProcessing = false
        this.isFromSaved = true
      })

      this.timeoutId = setTimeout(() => {
        this.isFromSaved = false
      }, 3000);
    },
    syncFormDebounde: debounce(function () {
      this.syncForm()
    }, 500)
  },
  unmounted() {
    clearTimeout(this.refresh);
  },
  
};
</script>

<style>
.w-400 {
  width: 400px;
}

.w-800 {
  width: 800px;
}
</style>
