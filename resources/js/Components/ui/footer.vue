<script setup>
import setting from '@/lib/setting.js';
</script>

<template>
    <div class="px-8 pt-0 pb-4 -mt-4 text-xs font-semibold leading-none text-foreground/60">
        © {{ new Date().getFullYear() }} {{ setting.setting.app_dev }} - {{ setting.setting.app_inst }}
    </div>
</template>
