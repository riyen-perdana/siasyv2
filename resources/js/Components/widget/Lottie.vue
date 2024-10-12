<script setup>
import { Vue3Lottie } from 'vue3-lottie'
import AnimationLottie from '../../lib/searching.json';
</script>

<template>
    <div>
        <Vue3Lottie
            :animation-data="AnimationLottie"
            :height="200"
            :width="200"
        />
    </div>
</template>
