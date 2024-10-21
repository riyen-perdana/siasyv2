<template>

    <Head title="Otorisasi Pengguna Aplikasi" />
    <AuthenticatedLayout>
        <template #content>
            <Info title="Otorisasi Pengguna Aplikasi" :isGreating=false :breadcrumb="breadcrumb"
                :subtitles="subtitles" />
            <div class="flex mt-4"></div>
            <div class="flex flex-row items-center justify-end">
                <Dialog v-model:open="open" :modal="true">
                    <DialogTrigger as-child>
                        <Button variant="default" class="text-xs rounded-none" @click="open = true">
                            Tambah Otorisasi
                            <Icon :style="{ color: 'text-foreground', 'margin-left': '5px' }"
                                :icon="'basil:add-outline'" :inline="true" :height="'20'" />
                        </Button>
                    </DialogTrigger>
                    <DialogContent class="sm:max-w-[425px] md:max-w-[700px]">
                        <DialogHeader>
                            <DialogTitle>
                                {{ headerDialog }}
                            </DialogTitle>
                            <DialogDescription class="text-xs">
                                {{ descriptionDialog }}
                            </DialogDescription>
                        </DialogHeader>
                        <Form :permissions="props.permissions" @closeModal="closeModal" />
                    </DialogContent>
                </Dialog>
            </div>
            <div class="flex items-center justify-between mb-10">

            </div>

        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import { computed, reactive, ref, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Info from '@/Components/widget/Info.vue';
import Button from '@/shadcn/ui/button/Button.vue';
import { Icon } from '@iconify/vue';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/shadcn/ui/dialog';

import Form from '@/Pages/Apps/Roles/Form.vue';

const isEditData = ref(false);
const open = ref(false);

const props = defineProps({
    roles: Object,
    permissions: Array
});

const closeModal = () => {
    open.value = false;
}

const breadcrumb = [
    {
        label: 'Dashboard',
        href: '/dashboard',
        isActive: true
    },
    {
        label: 'Otorisasi Aplikasi',
        href: '#',
        isActive: false
    }
];

const subtitles = 'Layanan otorisasi pengguna aplikasi meliputi lihat, tambah, edit, dan hapus data otorisasi pengguna aplikasi.';
const headerDialog = computed(() => {
    return isEditData.value ? 'Edit Otorisasi Pengguna Aplikasi' : 'Tambah Otorisasi Pengguna Aplikasi';
});
const descriptionDialog = computed(() => {
    return isEditData.value ? 'Edit data otorisasi pengguna aplikasi.' : 'Tambah data otorisasi pengguna aplikasi, Isian dengan tanda asterik (*) harus diisi.';
});
</script>
