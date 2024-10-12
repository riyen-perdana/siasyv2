<template>
    <div>
        <div class="text-[13px] text-muted-foreground mt-3">
            Menampilkan data {{ count.from }} sampai {{ count.to }} dari {{ count.total }} data
        </div>
        <div class="col-sm-6">

        </div>

        <!-- <div class="col-sm-6">
            <ul class="pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
                <li :class="[
                        'page-item',
                        link.url == null ? 'disabled' : '',
                        link.active ? 'active' : '',
                    ]"
                    v-for="(link, index) in links" :key="index">
                        <Link
                            preserve-scroll
                            class="page-link"
                            :href="link.url === null ? '#' : link.url+'&perPage='+perPage"
                            v-html="link.label">
                        </Link>
                </li>
            </ul>
        </div> -->
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    count: Object,
    perPage: Number,
});
</script>
