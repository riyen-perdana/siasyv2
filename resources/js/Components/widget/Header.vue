<template>
    <div class="border-b">
        <div class="flex items-center h-16 px-4">
            <!-- <TeamSwitcher /> -->
            <AppLogo />
            <div class="flex items-center ml-auto space-x-4">
                <!-- <Search /> -->
                <MainNav class="mx-6" />
                <UserNav />
            </div>
        </div>
    </div>
</template>

<script setup>
import UserNav from '@/Components/UserNav.vue';
import AppLogo from '@/Components/ui/ApplicationLogo.vue';
import MainNav from '@/Components/MainNav.vue';
</script>
