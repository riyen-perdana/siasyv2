<template>
    <Head title="Perizinan Aplikasi" />
    <AuthenticatedLayout>
        <template #content>
            <Info
                title="Perizinan Aplikasi"
                :isGreating="false"
                :breadcrumb="breadcrumb"
                :subtitles="subtitles"
            />
            <div class="flex mt-4"></div>
            <div class="flex flex-row items-center justify-end">
                <div class="flex items-center space-x-2" v-if="isSelected">
                    <p class="text-[13px] underline text-red-500 font-semibold">
                        {{ data.selectedItems.length }} data perizinan dipilih
                    </p>
                    <Button variant="destructive" class="text-xs rounded-none" @click="deleteAllSelected()">
                        Hapus Perizinan
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
                            Tambah Perizinan
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
                    <DialogContent class="sm:max-w-[425px] md:max-w-[700px]">
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
                            @closeModal="closeModal"
                            @toastMessage="toastMessage"
                        />
                    </DialogContent>
                </Dialog>
            </div>
            <div class="flex items-center justify-between mb-10">
                <div class="flex lg:w-full md:w-full">
                    <div class="relative lg:w-full md:w-full">
                        <Input
                            v-model="data.params.search"
                            placeholder="Cari Perizinan Aplikasi"
                            class="text-[13px] w-[50%] pl-10"
                        />
                        <span
                            class="absolute inset-y-0 flex items-center justify-center px-2 start-0"
                        >
                            <Search class="size-4 text-muted-foreground" />
                        </span>
                    </div>
                </div>
                <div class="flex items-center justify-end w-full space-x-2">
                    <p class="text-[13px] font-medium">Baris per Halaman</p>
                    <div class="flex items-center justify-end space-x-2 py-4">
                        <Select
                            :model-value="perPageData"
                            @update:model-value="perPageData = $event"
                        >
                            <SelectTrigger
                                class="rounded-none h-9 focus:ring-0 ring-inset w-[70px]"
                            >
                                <SelectValue
                                    class="text-[13px]"
                                    :placeholder="perPageData"
                                />
                            </SelectTrigger>
                            <SelectContent
                                class="text-[13px] rounded-none focus:ring-0"
                            >
                                <SelectGroup>
                                    <SelectItem
                                        v-for="item in [10, 25, 50, 100]"
                                        :key="item"
                                        :value="`${item}`"
                                        class="text-[13px]"
                                    >
                                        {{ item }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                    </div>
                </div>
            </div>
            <section name="table">
                <div class="flex w-full">
                    <Table
                        class="text-[13px] rounded-md border"
                        :class="isData ? 'border-b' : ''"
                    >
                        <TableHeader>
                            <TableRow>
                                <TableHead
                                    class="w-[2%] [&:has([role=checkbox])]:inline-flex [&:has([role=checkbox])]:items-center"
                                    ><input
                                        class="peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground"
                                        type="checkbox"
                                        v-model="data.isAllSelected"
                                        @click="selectAll()"
                                /></TableHead>
                                <TableHead class="w-[3%]">No.</TableHead>
                                <TableHead class="w-[82%]">
                                    <Button
                                        variant="ghost"
                                        class="text-[13px]"
                                        @click="order('name')"
                                    >
                                        Perizinan Aplikasi
                                        <ArrowUpDown class="h-4 w-4 ml-2" />
                                    </Button>
                                </TableHead>
                                <TableHead class="w-[15%] text-center">
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow
                                v-for="(item, index) in permissions?.data"
                                :key="index"
                            >
                                <TableCell
                                    class="w-[2%] [&:has([role=checkbox])]:inline-flex [&:has([role=checkbox])]:items-center"
                                    ><input
                                        class="peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground"
                                        type="checkbox"
                                        v-model="data.selectedItems"
                                        :value="item.id"
                                        @change="selectItem()"
                                /></TableCell>
                                <TableCell>
                                    {{
                                        (permissions?.current_page - 1) *
                                            permissions?.per_page +
                                        index +
                                        1
                                    }}.
                                </TableCell>
                                <TableCell class="text-[13px] px-8">{{
                                    item.name
                                }}</TableCell>
                                <TableCell
                                    class="text-[13px] text-xs flex justify-end space-x-2"
                                >
                                    <Button
                                        class="text-xs h-2 px-2 text-green-500"
                                        variant="link"
                                        @click="editData(item)"
                                        >Ubah
                                        <Icon
                                            :style="{
                                                color: 'text-green-500',
                                                'margin-left': '2px',
                                            }"
                                            :icon="'ri:edit-line'"
                                            :inline="true"
                                            :height="'15'"
                                        />
                                    </Button>
                                    <Separator
                                        orientation="vertical"
                                        class="h-4"
                                    />
                                    <AlertDialog>
                                        <AlertDialogTrigger as-child>
                                            <Button
                                                class="text-xs px-2 text-red-500 h-2"
                                                variant="link"
                                                >Hapus
                                                <Icon
                                                    :style="{
                                                        color: 'text-green-500',
                                                        'margin-left': '2px',
                                                    }"
                                                    :icon="'ri:delete-bin-line'"
                                                    :inline="true"
                                                    :height="'15'"
                                                />
                                            </Button>
                                        </AlertDialogTrigger>
                                        <AlertDialogContent>
                                            <AlertDialogHeader>
                                                <AlertDialogTitle>
                                                    Apakah Anda Yakin Akan
                                                    Menghapus Data Ini?
                                                </AlertDialogTitle>
                                                <AlertDialogDescription
                                                    class="text-xs"
                                                >
                                                    Data Tidak Akan Bisa
                                                    Dikembalikan Apabila Sudah
                                                    Dihapus.
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
                                                    @click="deleteData(item.id)"
                                                >
                                                    Ya, Saya Yakin
                                                </AlertDialogAction>
                                            </AlertDialogFooter>
                                        </AlertDialogContent>
                                    </AlertDialog>
                                    <!-- <Button class="text-xs px-2 text-red-500 h-2" variant="link" @click="deleteData(item.id)">Hapus
                                        <Icon :style="{ color: 'text-green-500', 'margin-left': '2px' }"
                                        :icon="'ri:delete-bin-line'" :inline="true" :height="'15'" />
                                    </Button> -->
                                </TableCell>
                            </TableRow>
                            <TableEmpty
                                v-if="!isData"
                                :colspan="3"
                                class="text-[13px]"
                            >
                                <div
                                    class="flex flex-col items-center justify-center h-full"
                                >
                                    <!-- <Lottie /> -->
                                    <no-data />
                                </div>
                            </TableEmpty>
                        </TableBody>
                    </Table>
                </div>
                <div v-if="isData">
                    <Pagination
                        :count="permissions"
                        :perPage="data.params.perPage"
                        :links="permissions.links"
                        :search="data.params.search"
                        :field="data.params.field"
                        :order="data.params.order"
                    />
                </div>
            </section>
        </template>
    </AuthenticatedLayout>
    <Toaster />
</template>

<script setup>
import { computed, reactive, watch, ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import Info from "@/Components/widget/Info.vue";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
    TableEmpty,
} from "@/shadcn/ui/table";
import Separator from "@/shadcn/ui/separator/Separator.vue";
import Input from "@/shadcn/ui/input/Input.vue";
import { Search, ArrowUpDown } from "lucide-vue-next";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/shadcn/ui/select";
import Pagination from "@/Components/widget/Pagination.vue";
import { cloneDeep, debounce, pickBy } from "lodash";
import NoData from "@/Components/widget/NoData.vue";
import Button from "@/shadcn/ui/button/Button.vue";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/shadcn/ui/dialog";

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

import { useToast } from "@/shadcn/ui/toast/use-toast";
import { Toaster } from "@/shadcn/ui/toast";

import { Icon } from "@iconify/vue";
import Form from "@/Pages/Apps/Permission/Form.vue";

const props = defineProps({
    permissions: Object,
    filters: Object,
    perPage: Number,
});

const { toast } = useToast();

const perPageData = computed({
    get: () => props.perPage.toString(),
    set: (value) => {
        data.params.perPage = value;
        let param = pickBy(data.params);
        router.get(
            "/apps/perizinan-aplikasi",
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

const selectAll = () => {
    data.isAllSelected = !data.isAllSelected;
    if (data.isAllSelected) {
        data.selectedItems = props.permissions.data.map((item) => item.id);
    } else {
        data.selectedItems = [];
    }
    console.log(data.selectedItems);
    console.log("Jumlah Data Di Pilih : " + data.selectedItems.length);
};

const selectItem = () => {
    if (data.selectedItems.length == props.permissions.data.length) {
        data.isAllSelected = true;
        console.log(data.selectedItems);
        console.log("Jumlah Data Di Pilih : " + data.selectedItems.length);
    } else {
        data.isAllSelected = false;
        console.log(data.selectedItems);
        console.log("Jumlah Data Di Pilih : " + data.selectedItems.length);
    }
};

const isSelected = computed(() => {
    return data.selectedItems.length > 0 ? true : false;
});

const order = (column) => {
    data.params.field = column;
    data.params.order = data.params.order === "asc" ? "desc" : "asc";
};

const breadcrumb = [
    {
        label: "Dashboard",
        href: "/dashboard",
        isActive: true,
    },
    {
        label: "Perizinan Aplikasi",
        href: "#",
        isActive: false,
    },
];

const subtitles =
    "Layanan perizinan aplikasi meliputi lihat, tambah, edit, dan hapus data perizinan penggunaan aplikasi.";

const headerModalDialog = computed(() => {
    return isEditData.value
        ? "Edit Perizinan Aplikasi"
        : "Tambah Perizinan Pengguna Aplikasi";
});

const isData = computed(() => props.permissions.data.length > 0);

const isEditData = ref(false);
const isDataEdit = ref({});
const openModal = ref(false);

const addData = () => {
    openModal.value = true;
    isEditData.value = false;
    data.dataEdit = {};
};
const editData = (item) => {
    data.dataEdit = item;
    isEditData.value = true;
    openModal.value = true;
};

const closeModal = () => {
    isEditData.value = false;
    openModal.value = false;
};

const toastMessage = (id) => {
    if (id) {
        toast({
            title: "Berhasil !!",
            description: "Perizinan Aplikasi Berhasil Diubah.",
            variant: "success",
        });
    } else {
        toast({
            title: "Berhasil !!",
            description: "Perizinan Aplikasi Berhasil Ditambahkan.",
            variant: "success",
        });
    }
};
const deleteData = (id) => {
    router.delete(`/apps/perizinan-aplikasi/${id}`, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast({
                title: "Berhasil !!",
                description: "Perizinan Aplikasi Berhasil Dihapus.",
                variant: "success",
            });
        },
        onError: () => {
            toast({
                title: "Ups, Terjadi Kesalahan !!",
                description: "Perizinan Aplikasi Gagal Dihapus.",
                variant: "destructive",
            });
        },
    });
};

const deleteAllSelected = () => {
    //console.log(data.selectedItems);
    router.post(
        "/apps/perizinan-aplikasi/delete-all",
        {
            ids: data.selectedItems,
        },
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast({
                    title: "Berhasil !!",
                    description: "Perizinan Aplikasi Berhasil Dihapus.",
                    variant: "success",
                });
                data.selectedItems = []
                data.isAllSelected = false
            },
            onError: () => {
                toast({
                    title: "Ups, Terjadi Kesalahan !!",
                    description: "Perizinan Aplikasi Gagal Dihapus.",
                    variant: "destructive",
                });
            },
        }
    );
};

watch(
    () => cloneDeep(data.params),
    debounce(() => {
        let param = pickBy(data.params);
        console.log(param);
        router.get("/apps/perizinan-aplikasi", param, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        });
    }, 150)
);
</script>
