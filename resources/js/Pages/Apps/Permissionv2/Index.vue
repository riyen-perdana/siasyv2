<script setup>
import { Head, router, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Info from "@/Components/widget/Info.vue";

// Import Tanggal 22/12/2024
import {
    FlexRender,
    getCoreRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    getExpandedRowModel,
    getFilteredRowModel,
} from "@tanstack/vue-table";

import { ArrowUpDown, ChevronDown } from "lucide-vue-next";
import { h, ref } from "vue";
import { Checkbox } from "@/shadcn/ui/checkbox";
import { Badge } from "@/shadcn/ui/badge";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuCheckboxItem,
    DropdownMenuTrigger,
} from "@/shadcn/ui/dropdown-menu";
import { Input } from "@/shadcn/ui/input";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/shadcn/ui/table";
import { valueUpdater } from "@/lib/utils";
import {
    ChevronRightIcon,
    ChevronLeftIcon,
    DoubleArrowLeftIcon,
    DoubleArrowRightIcon,
} from "@radix-icons/vue";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/shadcn/ui/select";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/shadcn/ui/dialog";
import { Plus, Upload } from "lucide-vue-next";
import { Textarea } from "@/shadcn/ui/textarea";
import {
    TagsInput,
    TagsInputInput,
    TagsInputItem,
    TagsInputItemDelete,
    TagsInputItemText,
} from "@/shadcn/ui/tags-input";
import { Toast } from "@/shadcn/ui/toast";
import { Popover, PopoverContent, PopoverTrigger } from "@/shadcn/ui/popover";
import Button from "@/shadcn/ui/button/Button.vue";
import { row } from "@unovis/ts/components/timeline/style";

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
    "Layanan perizinan aplikasi meliputi lihat data perizinan penggunaan aplikasi.";

const props = defineProps({
    data: Object,
    filter: Array,
});
const data = props.data.data;
// Columns
const columns = [
    {
        id: "select",
        header: ({ table }) =>
            h(Checkbox, {
                checked:
                    table.getIsAllRowsSelected() ||
                    (table.getIsSomeRowsSelected() && "indeterminate"),
                "onUpdate:checked": (value) =>
                    table.toggleAllRowsSelected(!!value),
                "aria-label": "Pilih Semua",
            }),
        cell: ({ row }) =>
            h(Checkbox, {
                checked: row.getIsSelected(),
                "onUpdate:checked": (value) => row.toggleSelected(!!value),
                "aria-label": "Pilih",
            }),
        enableSorting: false,
        enableHiding: false,
    },
    {
        accessorKey: "name",
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => [
                    "Perizinan Aplikasi",
                    h(ArrowUpDown, { class: "h-4 w-4" }),
                ]
            );
        },
        cell: ({ row }) =>
            h("div", { class: "lowercase" }, row.getValue("name")),
        enableSorting: true,
        enableHiding: false,
    },
];

const sorting = ref([]);
const columnFilters = ref([props.filter.search] ?? []);
const columnVisibility = ref({});
const rowSelection = ref({});
const expanded = ref({});
const pageSizes = [1, 2, 3, 5, 10, 15, 30, 40, 50, 100];
const pagination = ref({
    pageIndex: props.data.current_page - 1,
    pageSize: props.data.per_page,
});
</script>

<template lang="html">
    <div>
        <Head title="Perizinan Aplikasi Versi 2" />
        <AuthenticatedLayout>
            <template #content>
                <Info
                    title="Perizinan Aplikasi Versi 2"
                    :isGreating="false"
                    :breadcrumb="breadcrumb"
                    :subtitles="subtitles"
                />
            </template>
        </AuthenticatedLayout>
    </div>
</template>
