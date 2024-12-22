<template>
    <div class="flex items-center justify-between space-y-2">
        <div>
            <h2 class="text-3xl font-semibold tracking-tight">
                {{ props.title }}
            </h2>
            <div v-if="props.isGreating">
                <p class="text-[13px] text-muted-foreground">
                    Assalamualaikum <span class="font-semibold text-foreground">{{ $page.props.auth?.user?.full_nm_user
                        }}</span>, Selamat Datang di Dashboard {{ setting.setting.app_name }}
                </p>
            </div>
            <div v-else>
                <p class="text-[13px] text-muted-foreground">
                    {{ props.subtitles }}
                </p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <!-- <DateRangePicker />
            <Button>Download</Button> -->
            <Breadcumb :item="props.breadcrumb" />
        </div>
    </div>
</template>

<script setup>
import setting from '@/lib/setting';
import Breadcumb from '@/Components/ui/Breadcumb.vue';

const props = defineProps({
    title: { type: String, required: true },
    subtitles: { type: String, required: false },
    breadcrumb: { type: Array, required: true },
    isGreating: { type: Boolean, required: false, default: false },
});

</script>
