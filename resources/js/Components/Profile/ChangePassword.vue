<script setup>
import BreezeLink from '@/Components/NavLink.vue';
</script>

<template>
    <div class="flex justify-between mt-12">
        <div class="w-1/4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-3xl">
                Hasło
            </h2>
            <p class="mt-3 text-l">
                Tutaj możesz zmienić swoje hasło.
            </p>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-4/6">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="">
                    
                </form>
            </div>
        </div>
    </div>    
</template>

<script>
import swal from 'sweetalert2';

export default {
    props: {
        accessTokens: Array,
    }, methods: {
        showToken ( token ) {
            swal.fire({
                title: 'Klucz API',
                text: token.id,
                icon: 'info',
                confirmButtonText: 'OK'
            })
        }, CreateToken () {
            this.$inertia.get(route('profile.create-token'));
        }
    }
}
</script>