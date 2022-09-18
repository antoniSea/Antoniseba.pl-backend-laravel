<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Navbar from '@/Components/LandingPage/Navbar.vue';
</script>
<template>
    <Navbar :user="user" />
</template>

<script>
export default {
    props: {
        user: { type: Object },
    },
};
</script>