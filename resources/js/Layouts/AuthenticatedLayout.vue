<script setup>
import Footer from '@/Components/ui/footer.vue';
import Header from '@/Components/widget/Header.vue';

</script>

<template>
  <div class="flex-col hidden min-h-screen md:flex">
    <Header />
    <div class="flex-1 p-8 pt-6 space-y-4">
        <slot name="content" />
    </div>
    <Footer />
  </div>
</template>
