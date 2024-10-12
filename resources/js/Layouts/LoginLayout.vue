<template>
    <div class="min-h-screen bg-background">
        <div class="flex justify-center h-screen">
            <div class="hidden border-r-2 border-slate-100 lg:block lg:w-2/3">
                <div class="flex items-center justify-center h-full overflow-hidden">
                    <img src="../../../public/images/pattern_vue.jpg" alt="">
                </div>
            </div>
            <div class="flex items-center justify-center w-full max-w-* px-6 mx-auto bg-slate-50 lg:w-2/6">
                <div class="w-full py-4 mt-6 overflow-hidden sm:max-w-md sm:rounded-lg">
                    <div class="flex flex-col gap-y-5">
                        <ApplicationLogo />
                        <div>
                            <slot />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import ApplicationLogo from '@/Components/ui/ApplicationLogo.vue';
</script>
