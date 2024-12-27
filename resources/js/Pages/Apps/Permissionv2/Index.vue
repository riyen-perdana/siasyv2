<script setup>
import { Head, router, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Info from "@/Components/widget/Info.vue";
import { cloneDeep, debounce, pickBy } from "lodash";

// Import Tanggal 22/12/2024
import {
    FlexRender,
    getCoreRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    getExpandedRowModel,
    getFilteredRowModel,
    useVueTable,
} from "@tanstack/vue-table";

import { ArrowUpDown, ChevronDown, Search } from "lucide-vue-next";
import { h, ref, watch, computed, onDeactivated } from "vue";
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
    CheckCircledIcon,
    MinusCircledIcon,
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
const filters = ref(props.filter);
// Columns
const columns = [
    {
        id: "no",
        header: () => {
            return h("div", { class: "text-[13px]" }, "No.");
        },
        meta: {
            headerClassName: "w-[3%]", // fixed width
        },
        cell: ({ row }) =>
            h(
                "div",
                { class: "lowercase text-[13px] w-[3%]" },
                pagination.value.pageIndex * pagination.value.pageSize +
                    row.index +
                    1 +
                    "."
            ),
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
                    class: "text-[13px]",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => [
                    "Perizinan Aplikasi",
                    h(ArrowUpDown, {
                        class: "h-4 w-4 ml-2",
                    }),
                ]
            );
        },
        cell: ({ row }) =>
            h("div", { class: "text-[13px] px-4" }, row.getValue("name")),
        enableSorting: true,
        enableHiding: false,
    },
];

const sorting = ref([]);
const columnFilters = ref(props.filter ?? []);
const columnVisibility = ref({});
const rowSelection = ref({});
const expanded = ref({});
const pageSizes = [1, 2, 3, 5, 10, 15, 30, 40, 50, 100];
const pagination = ref({
    pageIndex: props.data.current_page - 1,
    pageSize: props.data.per_page,
});

const table = useVueTable({
    data,
    columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getExpandedRowModel: getExpandedRowModel(),
    pageCount: props.data.last_page,
    manualPagination: true,
    manualSorting: true,
    manualFiltering: true,
    onPaginationChange: (updater) => {
        if (typeof updater === "function") {
            pagination.value = updater(pagination.value);
        } else {
            pagination.value = updater;
        }
        router.get(
            route("apps.permissionv2.index"),
            {
                page: pagination.value.pageIndex + 1,
                per_page: pagination.value.pageSize,
                sort_field: sorting.value[0]?.id,
                sort_direction:
                    sorting.value.length == 0
                        ? undefined
                        : sorting.value[0]?.desc
                        ? "desc"
                        : "asc",
                ...filters,
            },
            { preserveState: true, preserveScroll: true }
        );
    },
    onSortingChange: (updaterOrValue) => {
        if (typeof updaterOrValue === "function") {
            sorting.value = updaterOrValue(sorting.value);
        } else {
            sorting.value = updaterOrValue;
        }
        let filters = {};
        if (columnFilters.value) {
            filters = columnFilters.value.reduce((acc, filter) => {
                acc[filter.id] = filter.value;
                return acc;
            }, {});
        }
        router.get(
            route("apps.permissionv2.index"),
            {
                page: pagination.value.pageIndex + 1,
                per_page: pagination.value.pageSize,
                sort_field: sorting.value[0]?.id,
                sort_direction:
                    sorting.value.length == 0
                        ? undefined
                        : sorting.value[0]?.desc
                        ? "desc"
                        : "asc",
                ...filters,
            },
            { preserveState: true, preserveScroll: true }
        );
    },
    onColumnFiltersChange: (updaterOrValue) => {
        if (typeof updaterOrValue === "function") {
            columnFilters.value = updaterOrValue(columnFilters.value);
        } else {
            columnFilters.value = updaterOrValue;
        }
        if (columnFilters.value) {
            filters = columnFilters.value.reduce((acc, filter) => {
                acc[filter.id] = filter.value;
                return acc;
            }, {});
            // router.get(
            //     route("apps.permissionv2.index"),
            //     {
            //         page: pagination.value.pageIndex + 1,
            //         per_page: pagination.value.pageSize,
            //         sort_field: sorting.value[0]?.id,
            //         sort_direction:
            //             sorting.value.length == 0
            //                 ? undefined
            //                 : sorting.value[0]?.desc
            //                 ? "desc"
            //                 : "asc",
            //         ...filters,
            //     },
            //     { replace: true, preserveState: false, preserveScroll: true }
            // );
        }
        watch(
            () => cloneDeep(columnFilters.value), debounce(() => {
                router.get(
                    route("apps.permissionv2.index"),
                    {
                        page: pagination.value.pageIndex + 1,
                        per_page: pagination.value.pageSize,
                        sort_field: sorting.value[0]?.id,
                        sort_direction:
                            sorting.value.length == 0
                                ? undefined
                                : sorting.value[0]?.desc
                                ? "desc"
                                : "asc",
                        ...filters,
                    },
                    { replace: true, preserveState: true, preserveScroll: true }
                );
            })
        )
    },
    onColumnVisibilityChange: (updaterOrValue) =>
        valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: (updaterOrValue) =>
        valueUpdater(updaterOrValue, rowSelection),
    onExpandedChange: (updaterOrValue) =>
        valueUpdater(updaterOrValue, expanded),
    state: {
        get sorting() {
            return sorting.value;
        },
        get columnFilters() {
            return columnFilters.value;
        },
        get columnVisibility() {
            return columnVisibility.value;
        },
        get rowSelection() {
            return rowSelection.value;
        },
        get expanded() {
            return expanded.value;
        },
        get pagination() {
            return pagination.value;
        },
    },
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
                <div class="flex mt-4"></div>
                <div class="flex items-center justify-between mb-10">
                    <div class="flex lg:w-full">
                        <div class="relative lg:w-[100%] md:w-[75%]">
                            <Input
                                class="max-w-sm pl-10 text-[13px]"
                                placeholder="Cari Perizinan Aplikasi"
                                :model-value="
                                    table.getColumn('name')?.getFilterValue()
                                "
                                @update:model-value="
                                    table
                                        .getColumn('name')
                                        ?.setFilterValue($event)
                                "
                            />
                            <span
                                class="absolute inset-y-0 flex items-center justify-center px-2 start-0"
                            >
                                <Search class="size-4 text-muted-foreground" />
                            </span>
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-end w-full space-x-2"
                    ></div>
                </div>
                <section name="table">
                    <div class="rounded-md border">
                        <Table>
                            <TableHeader>
                                <TableRow
                                    v-for="headerGroup in table.getHeaderGroups()"
                                    :key="headerGroup.id"
                                >
                                    <TableHead
                                        v-for="header in headerGroup.headers"
                                        :key="header.id"
                                        :class="
                                            header.column.columnDef.meta
                                                ?.headerClassName
                                        "
                                    >
                                        <FlexRender
                                            v-if="!header.isPlaceholder"
                                            :render="
                                                header.column.columnDef.header
                                            "
                                            :props="header.getContext()"
                                        />
                                    </TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <template
                                    v-if="table.getRowModel().rows?.length"
                                >
                                    <template
                                        v-for="row in table.getRowModel().rows"
                                        :key="row.id"
                                    >
                                        <TableRow
                                            :data-state="
                                                row.getIsSelected() &&
                                                'selected'
                                            "
                                        >
                                            <TableCell
                                                v-for="cell in row.getVisibleCells()"
                                                :key="cell.id"
                                            >
                                                <FlexRender
                                                    :render="
                                                        cell.column.columnDef
                                                            .cell
                                                    "
                                                    :props="cell.getContext()"
                                                />
                                            </TableCell>
                                        </TableRow>
                                        <TableRow v-if="row.getIsExpanded()">
                                            <TableCell
                                                :colspan="
                                                    row.getAllCells().length
                                                "
                                            >
                                                {{
                                                    JSON.stringify(row.original)
                                                }}
                                            </TableCell>
                                        </TableRow>
                                    </template>
                                </template>

                                <TableRow v-else>
                                    <TableCell
                                        :colspan="columns.length"
                                        class="h-24 text-center"
                                    >
                                        No results.
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                    <div class="flex items-center justify-end space-x-2 py-4">
                        <div
                            class="flex-1 text-[13px] font-medium text-muted-foreground"
                        >
                            Menampilkan Halaman
                            {{ table.getState().pagination.pageIndex + 1 }} Dari
                            {{ table.getPageCount() }} Halaman
                        </div>
                        <div class="flex items-center space-x-2">
                            <p class="text-[13px] font-medium">Rows per page</p>
                            <Select
                                :model-value="
                                    table
                                        .getState()
                                        .pagination.pageSize.toString()
                                "
                                @update:model-value="
                                    (value) => table.setPageSize(Number(value))
                                "
                            >
                                <SelectTrigger class="h-8 w-[70px]">
                                    <SelectValue
                                        :placeholder="
                                            table
                                                .getState()
                                                .pagination.pageSize.toString()
                                        "
                                    />
                                </SelectTrigger>
                                <SelectContent side="top">
                                    <SelectItem
                                        v-for="pageSize in pageSizes"
                                        :key="pageSize"
                                        :value="pageSize.toString()"
                                    >
                                        {{ pageSize }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                        <div class="space-x-2">
                            <div class="flex items-center space-x-2">
                                <Button
                                    variant="outline"
                                    class="hidden h-8 w-8 p-0 lg:flex"
                                    :disabled="!table.getCanPreviousPage()"
                                    @click="table.setPageIndex(0)"
                                >
                                    <DoubleArrowLeftIcon class="h-4 w-4" />
                                </Button>
                                <Button
                                    variant="outline"
                                    class="h-8 w-8 p-0"
                                    :disabled="!table.getCanPreviousPage()"
                                    @click="table.previousPage()"
                                >
                                    <ChevronLeftIcon class="h-4 w-4" />
                                </Button>
                                <Button
                                    variant="outline"
                                    class="h-8 w-8 p-0"
                                    :disabled="!table.getCanNextPage()"
                                    @click="table.nextPage()"
                                >
                                    <ChevronRightIcon class="h-4 w-4" />
                                </Button>
                                <Button
                                    variant="outline"
                                    class="hidden h-8 w-8 p-0 lg:flex"
                                    :disabled="!table.getCanNextPage()"
                                    @click="
                                        table.setPageIndex(
                                            table.getPageCount() - 1
                                        )
                                    "
                                >
                                    <DoubleArrowRightIcon class="h-4 w-4" />
                                </Button>
                            </div>
                        </div>
                    </div>
                </section>
            </template>
        </AuthenticatedLayout>
    </div>
</template>
