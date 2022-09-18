<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import BreezeLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h1 class="text-4xl font-bold">
                            Token API: {{ token.id }} 
                        </h1>
                        <p class="text-gray-600 mt-4">
                            nazwa: {{ token.name }}
                        </p>
                        <p class="text-gray-600 mt-4" @click="copyToken" role="button">
                            token: {{ token.access_token }}
                        </p>
                        <div>
                            <button class="mt-8 px-4 py-2 bg-red-500 rounded" @click="DeleteToken">
                                Usuń token
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import swal from 'sweetalert2';

export default {
    props: {
        token: Object,
        users: Object
    }, methods: {
        DeleteToken() {
            // warning message
            swal.fire({
                title: 'Uwaga!',
                text: 'Token będzie usunięty bezpowrotnie! Ta akcja prawdopodobnie wyloguje użytkownika!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tak, usuń token!',
                cancelButtonText: 'Anuluj'
            }).then((result) => {
                if (result.value) {
                    this.$inertia.delete(this.route('profile.delete-token', { id: this.token.id }));
                }
            });
        }, copyToken() {
            // copy token to clipboard
            const el = document.createElement('textarea');
            el.value = this.token.access_token;
            el.setAttribute('readonly', '');
            el.style.position = 'absolute';
            el.style.left = '-9999px';
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);

            swal.fire({
                title: 'Token skopiowany do schowka!',
                icon: 'success',
                timer: 1000
            });
        } ,         getResults(page = 1) {
            axios.get('example/results?page=' + page)
                .then(response => {
                    this.laravelData = response.data;
                });
        }
    }
}
</script>
