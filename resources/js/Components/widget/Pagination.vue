<template>
    <div class="flex items-center justify-end space-x-2 py-4">
        <div class="flex-1 text-[13px] font-medium text-muted-foreground">
            Menampilkan data {{ props.count.from }} sampai
            {{ props.count.to }} dari {{ props.count.total }} data
        </div>
        <div class="flex items-center space-x-2">
            <Button
                variant="outline"
                class="hidden h-8 w-8 p-0 lg:flex"
                :disabled="noPreviousPage"
                @click="loadPage(1)"
            >
                <DoubleArrowLeftIcon class="h-4 w-4" />
            </Button>
            <Button
                variant="outline"
                class="hidden h-8 w-8 p-0 lg:flex"
                :disabled="firstDisabled"
                @click="loadPage(props.count?.current_page - 1)"
            >
                <ChevronLeftIcon class="h-4 w-4" />
            </Button>
            <Button
                variant="outline"
                class="hidden h-8 w-8 p-0 lg:flex"
                @click="loadPage(props.count?.current_page + 1)"
                :disabled="lastDisabled"
            >
                <ChevronRightIcon class="h-4 w-4" />
            </Button>
            <Button
                variant="outline"
                class="hidden h-8 w-8 p-0 lg:flex"
                :disabled="noNextPage"
                @click="loadPage(props.count?.last_page)"
            >
                <DoubleArrowRightIcon class="h-4 w-4" />
            </Button>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import Button from "@/shadcn/ui/button/Button.vue";
import {
    ChevronRightIcon,
    ChevronLeftIcon,
    DoubleArrowLeftIcon,
    DoubleArrowRightIcon,
} from "@radix-icons/vue";

import { computed } from "vue";

const props = defineProps({
    count: Object,
    perPage: String,
    links: Object,
    search: String,
    field: String,
    order: String,
});

const loadPage = (page) => {
    router.get(
        "/apps/perizinan-aplikasi",
        {
            page: page,
            perPage: props.perPage,
            search: props.search,
            field: props.field,
            order: props.order
        },
        {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        }
    );
};

const noPreviousPage = computed(() => {
    return props.count?.current_page - 1 <= 0;
});

const noNextPage = computed(() => {
    return props.count?.current_page >= props.count?.last_page;
});


const firstDisabled = computed(() => {
    if (props.count?.current_page === 1) {
        return true;
    }
});

const lastDisabled = computed(() => {
    if (props.count?.current_page === props.count?.last_page) {
        return true;
    }
});
</script>
