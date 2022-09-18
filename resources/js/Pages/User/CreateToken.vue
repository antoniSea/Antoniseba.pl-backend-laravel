<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
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
                        <h1 class="text-4xl">
                            Stwórz token API: {{ title }}
                        </h1>
                        <form @submit.prevent="CreateToken">
                            <div>
                                <input class="mt-6 rounded w-1/2" role="button" placeholder="Nazwa" type="text" name="" id="" v-model="title">
                            </div>
                            <button class="mt-8 px-4 py-2 bg-green-500 rounded">
                                Stwórz token
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import swal from 'sweetalert2';

export default {
    data () {
        return {
            title: ''
        }
    },
    methods: {
        CreateToken() {
            swal.fire({
                title: 'Proszę wpisać hasło',
                input: 'password',
                inputPlaceholder: 'Hasło',
                showCancelButton: true,
                confirmButtonText: 'Utwórz',
                cancelButtonText: 'Anuluj'
            }).then((result) => {
                if (result.value) {
                    this.$inertia.post(this.route('profile.store-token'), {
                        title: this.title,
                        password: result.value
                    });
                }
            })
        }
    },
}
</script>
