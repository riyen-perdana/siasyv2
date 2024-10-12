<template>
    <div class="flex flex-col mt-4 mb-4 gap-y-5">
        <div class="flex flex-row items-center gap-x-2">
            <img src="../../../../public/images/logo-uin.png" alt="" class="h-[60px]">
            <img src="../../../../public/images/siasy.png" alt="" class="h-[70px] -mt-2">
            <div class="flex flex-col gap-y-1">
                <h3 class="text-[16px] font-semibold leading-none md:block lg:block text-indigo-950 font-['Lobster']">{{
                    setting.setting.app_name }}</h3>
                <h4 class="text-xs font-semibold leading-none md:block lg:block text-indigo-950">
                    {{ setting.setting.fakultas }}
                </h4>
                <h4 class="text-xs font-semibold leading-none md:block lg:block text-indigo-950">
                    {{ setting.setting.app_inst }}
                </h4>
            </div>
        </div>
    </div>
</template>

<script setup>
import setting from '@/lib/setting.js';
</script>
