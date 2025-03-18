<template>
    <Head title="Pengguna Aplikasi" />
    <AuthenticatedLayout>
        <template #content>
            <Info 
                title="Pengguna Aplikasi" 
                :is-greating="false"
                :breadcrumb="breadcrumb"
                :subtitles="subtitles"
            />
            <div class="flex mt-4"></div>
            <div class="flex flex-row items-center justify-end">
                <div class="flex items-center space-x-2" v-if="isSelected">
                    <p class="text-[13px] underline text-red-500 font-semibold">
                        {{ data.selectedItems.length }} data pengguna dipilih
                    </p>
                    <AlertDialog>
                        <AlertDialogTrigger as-child>
                            <Button
                                variant="destructive"
                                class="text-xs rounded-none"
                            >
                                Hapus Pengguna
                                <Icon
                                    :style="{
                                        color: 'text-foreground',
                                        'margin-left': '5px',
                                    }"
                                    :icon="'basil:folder-delete-outline'"
                                    :inline="true"
                                    :height="'20'"
                                />
                            </Button>
                        </AlertDialogTrigger>
                        <AlertDialogContent>
                            <AlertDialogHeader>
                                <AlertDialogTitle>
                                    Apakah Anda Yakin Akan Menghapus Data Ini?
                                </AlertDialogTitle>
                                <AlertDialogDescription class="text-xs">
                                    Data Tidak Akan Bisa Dikembalikan Apabila
                                    Sudah Dihapus.
                                </AlertDialogDescription>
                            </AlertDialogHeader>
                            <AlertDialogFooter>
                                <AlertDialogCancel
                                    class="text-xs ring-inset rounded-none"
                                >
                                    Batal
                                </AlertDialogCancel>
                                <AlertDialogAction
                                    class="text-xs ring-inset rounded-none bg-red-500 hover:bg-red-600"
                                    @click="deleteAllSelected()"
                                >
                                    Ya, Saya Yakin
                                </AlertDialogAction>
                            </AlertDialogFooter>
                        </AlertDialogContent>
                    </AlertDialog>
                </div>
                <Dialog
                    v-model:open="openModal"
                    :modal="true"
                    v-if="!isSelected"
                >
                    <DialogTrigger as-child>
                        <Button
                            variant="default"
                            class="text-xs rounded-none"
                            @click="addData()"
                        >
                            Tambah Pengguna
                            <Icon
                                :style="{
                                    color: 'text-foreground',
                                    'margin-left': '5px',
                                }"
                                :icon="'basil:add-outline'"
                                :inline="true"
                                :height="'20'"
                            />
                        </Button>
                    </DialogTrigger>
                    <DialogContent
                        class="sm:max-w-[425px] md:max-w-[700px] overflow-y-scroll max-h-screen"
                    >
                        <DialogHeader>
                            <DialogTitle>
                                {{ headerModalDialog }}
                            </DialogTitle>
                            <DialogDescription class="text-xs">
                                Isian dengan tanda asterik (*) harus diisi.
                            </DialogDescription>
                        </DialogHeader>
                        <Form
                            :errors="$page.props.errors"
                            :data="data.dataEdit"
                            :roles="props.roles"
                            @close-modal="closeModal"
                            @toastMessage="toastMessage"
                        />
                    </DialogContent>
                </Dialog>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, reactive, computed } from "vue";
import Info from "@/Components/widget/Info.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { useToast } from "@/shadcn/ui/toast/use-toast";
import { Toaster } from "@/shadcn/ui/toast";
import { Icon } from "@iconify/vue";
import Button from "@/shadcn/ui/button/Button.vue";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from "@/shadcn/ui/alert-dialog";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/shadcn/ui/dialog";

import Form from "@/Pages/Apps/Users/Form.vue";

const props = defineProps({
    filters: Object,
    users: Object,
    roles: Array,
    perPage: Number,
});

const { toast } = useToast();
const openModal = ref(false);
const isEditData = ref(false);

const addData = () => {
    openModal.value = true;
    isEditData.value = false;
    data.dataEdit = {};
};

const headerModalDialog = computed(() => {
    return isEditData.value
        ? "Edit Pengguna Aplikasi"
        : "Tambah Pengguna Aplikasi";
});

const closeModal = () => {
    isEditData.value = false;
    openModal.value = false;
};

const toastMessage = (id) => {
    if (id) {
        toast({
            title: "Berhasil !!",
            description: "Pengguna Aplikasi Berhasil Diubah.",
            variant: "success",
        });
    } else {
        toast({
            title: "Berhasil !!",
            description: "Pengguna Aplikasi Berhasil Ditambahkan.",
            variant: "success",
        });
    }
};

const perPageData = computed({
    get: () => props.perPage.toString(),
    set: (value) => {
        data.params.perPage = value;
        let param = pickBy(data.params);
        router.get(
            "/apps/otorisasi-aplikasi",
            {
                ...param,
            },
            {
                replace: true,
                preserveState: true,
                preserveScroll: true,
            }
        );
    },
});

const isSelected = ref(false);
const data = reactive({
    params: {
        search: props.filters.search,
        field: props.filters.field,
        order: props.filters.order,
        perPage: perPageData.value,
    },
    isAllSelected: false,
    selectedItems: [],
    dataEdit: {},
});

const breadcrumb = [
{
        label: "Dashboard",
        href: "/dashboard",
        isActive: true,
    },
    {
        label: "Pengguna Aplikasi",
        href: "#",
        isActive: false,
    },
];

const subtitles = "Layanan Pengguna Aplikasi meliputi tambah, edit, dan hapus data pengguna aplikasi.";
</script>