<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import RightSidebar from '@/Components/App/RightSidebar.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <Welcome />
        <template #right-sidebar>
            <RightSidebar></RightSidebar>
        </template>
    </AppLayout>
</template>
