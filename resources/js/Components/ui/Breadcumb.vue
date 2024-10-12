<script setup>
import { Link } from '@inertiajs/vue3';
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbSeparator,
    BreadcrumbPage
} from '@/shadcn/ui/breadcrumb';

const props = defineProps({
    item: { type: Object, required: true }
});

</script>

<template>
    <Breadcrumb>
        <BreadcrumbList class="text-[13px]">
            <BreadcrumbItem v-for="item in props.item">
                <BreadcrumbLink>
                    <div v-if="item.isActive">
                        <Link :href="item.href">{{ item.label }}</Link>
                    </div>
                    <div v-else>
                        {{ item.label }}
                    </div>
                </BreadcrumbLink>
                <div v-if="item.isActive">
                    <BreadcrumbSeparator />
                </div>
            </BreadcrumbItem>
        </BreadcrumbList>
    </Breadcrumb>
</template>
