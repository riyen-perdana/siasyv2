<script setup>
import { Head, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Info from "@/Components/widget/Info.vue";
import { h, ref, watch } from "vue";
import { ArrowUpDown, ChevronDown, Search } from "lucide-vue-next";
import { cloneDeep, debounce, pickBy } from "lodash";

//Shadcn UI
import { Button } from "@/shadcn/ui/button";
import { ChevronDownIcon } from "@radix-icons/vue";
import {
    DropdownMenu,
    DropdownMenuTrigger,
    DropdownMenuCheckboxItem,
    DropdownMenuContent,
} from "@/shadcn/ui/dropdown-menu";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/shadcn/ui/table";
import { Input } from "@/shadcn/ui/input";
import {
    FlexRender,
    getCoreRowModel,
    getExpandedRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
} from "@tanstack/vue-table";
import { useVueTable } from "@tanstack/vue-table";
import { valueUpdater } from "@/lib/utils";
import { filter } from "lodash";

const props = defineProps({
    data: Object,
    filter: Object,
});

const data = props.data.data;

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
                { class: "lowercase text-[13px] w-[3%]" }
                // pagination.value.pageIndex * pagination.value.pageSize +
                //     row.index +
                //     1 +
                //     "."
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
const columnFilters = ref([]);
const columnVisibility = ref({});
const rowSelection = ref({});
const expanded = ref({});

const table = useVueTable({
    data,
    columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getExpandedRowModel: getExpandedRowModel(),
    onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: (updaterOrValue) =>
        // valueUpdater(updaterOrValue, columnFilters),
        {
            if (typeof updaterOrValue === "function") {
                columnFilters.value = updaterOrValue(columnFilters.value);
            } else {
                columnFilters.value = updaterOrValue;
            }
            let filters = {};
            watch(
                () => cloneDeep(columnFilters.value),
                debounce(() => {
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
                        {
                            replace: true,
                            preserveState: false,
                            preserveScroll: true,
                        }
                    );
                }, 150)
            );
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
    },
});

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
                <div class="w-full">
                    <div class="flex items-center py-4">
                        <Input
                            class="max-w-sm"
                            placeholder="Filter emails..."
                            :model-value="
                                table.getColumn('name')?.getFilterValue()
                            "
                            @update:model-value="
                                table.getColumn('name')?.setFilterValue($event)
                            "
                        />
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <Button variant="outline" class="ml-auto">
                                    Columns
                                    <ChevronDownIcon class="ml-2 h-4 w-4" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuCheckboxItem
                                    v-for="column in table
                                        .getAllColumns()
                                        .filter((column) =>
                                            column.getCanHide()
                                        )"
                                    :key="column.id"
                                    class="capitalize"
                                    :checked="column.getIsVisible()"
                                    @update:checked="
                                        (value) => {
                                            column.toggleVisibility(!!value);
                                        }
                                    "
                                >
                                    {{ column.id }}
                                </DropdownMenuCheckboxItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
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
                        <div class="flex-1 text-sm text-muted-foreground">
                            {{
                                table.getFilteredSelectedRowModel().rows.length
                            }}
                            of
                            {{ table.getFilteredRowModel().rows.length }} row(s)
                            selected.
                        </div>
                        <div class="space-x-2">
                            <Button
                                variant="outline"
                                size="sm"
                                :disabled="!table.getCanPreviousPage()"
                                @click="table.previousPage()"
                            >
                                Previous
                            </Button>
                            <Button
                                variant="outline"
                                size="sm"
                                :disabled="!table.getCanNextPage()"
                                @click="table.nextPage()"
                            >
                                Next
                            </Button>
                        </div>
                    </div>
                </div>
            </template>
        </AuthenticatedLayout>
    </div>
</template>
