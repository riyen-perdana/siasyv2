<template>

    <Head title="Perizinan Aplikasi" />
    <AuthenticatedLayout>
        <template #content>
            <Info title="Perizinan Aplikasi" :isGreating=false :breadcrumb="breadcrumb" :subtitles="subtitles" />
            <div class="flex mt-4"></div>
            <div class="flex items-center justify-between mb-10">
                <div class="flex lg:w-full md:w-full">
                    <div class="relative lg:w-full md:w-full">
                        <Input v-model="data.params.search" placeholder="Cari Perizinan Aplikasi" class="text-[13px] w-[50%] pl-10" />
                        <span class="absolute inset-y-0 flex items-center justify-center px-2 start-0">
                            <Search class="size-4 text-muted-foreground" />
                        </span>
                    </div>
                </div>
                <div class="flex items-center justify-end w-full space-x-2">
                    <p class="text-[13px] font-medium">Baris per Halaman</p>
                    <div class="flex items-center justify-end space-x-2 py-4">
                        <Select :model-value="perPageData" @update:model-value="perPageData = $event">
                            <SelectTrigger class="rounded-none h-9 focus:ring-0 ring-inset w-[70px]">
                                <SelectValue class="text-[13px]" :placeholder="perPageData" />
                            </SelectTrigger>
                            <SelectContent class="text-[13px] rounded-none focus:ring-0">
                                <SelectGroup>
                                    <SelectItem v-for="item in [10, 25, 50, 100]" :key="item" :value="`${item}`"
                                        class="text-[13px]">
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
                    <Table class="text-[13px] rounded-md border" :class="isData ? 'border-b' : ''">
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-[3%]">
                                    No.
                                </TableHead>
                                <TableHead class="w-[95%]">
                                    <Button variant="ghost" class="text-[13px]" @click="order('name')">
                                        Perizinan Aplikasi
                                        <ArrowUpDown class="h-4 w-4 ml-2" />
                                    </Button>
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="(item, index) in permissions?.data" :key="index">
                                <TableCell>{{ (permissions?.current_page - 1) * permissions?.per_page + index + 1 }}.
                                </TableCell>
                                <TableCell class="text-[13px] !px-8">{{ item.name }}</TableCell>
                            </TableRow>
                            <TableEmpty v-if="!isData" :colspan="2" class="text-[13px]">
                                <div class="flex flex-col items-center justify-center h-full">
                                    <!-- <Lottie /> -->
                                    <no-data />
                                </div>
                            </TableEmpty>
                        </TableBody>
                    </Table>
                </div>
                <div v-if="isData">
                    <Pagination :count="permissions" :perPage="data.params.perPage" :links="permissions.links" :search="data.params.search" />
                </div>
            </section>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import { computed, reactive, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Info from '@/Components/widget/Info.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
    TableEmpty
} from '@/shadcn/ui/table';
import Input from '@/shadcn/ui/input/Input.vue';
import { Search, ChevronDown, ChevronUp, ArrowUpDown } from 'lucide-vue-next';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/shadcn/ui/select';
import Pagination from '@/Components/widget/Pagination.vue';
import { cloneDeep, debounce, pickBy } from "lodash";
import NoData from '@/Components/widget/NoData.vue';
import Button from '@/shadcn/ui/button/Button.vue';

const props = defineProps({
    permissions: Object,
    filters: Object,
    perPage: Number
});

const perPageData = computed({
    get: () => props.perPage.toString(),
    set: (value) => {
        data.params.perPage = value
        let param = pickBy(data.params)
        router.get('/apps/perizinan-aplikasi', {
            ...param
        }, {
            replace: true,
            preserveState: true,
            preserveScroll: true
        })
    }
});

const data = reactive({
    params : {
        search: props.filters.search,
        field: props.filters.field,
        order: props.filters.order,
        perPage: perPageData.value
    }
});

const order = (column) => {
    data.params.field = column;
    data.params.order = data.params.order === 'asc' ? 'desc' : 'asc';
};

const breadcrumb = [
    {
        label: 'Dashboard',
        href: '/dashboard',
        isActive: true
    },
    {
        label: 'Perizinan Aplikasi',
        href: '#',
        isActive: false
    }
];

const subtitles = 'Layanan perizinan aplikasi meliputi lihat data perizinan penggunaan aplikasi.';
const isData = computed(() => props.permissions.data.length > 0);

watch(() => cloneDeep(data.params), debounce(() => {
    let param = pickBy(data.params)
    console.log(param)
    router.get('/apps/perizinan-aplikasi', param, {
        replace: true,
        preserveState: true,
        preserveScroll: true
    })
}, 150));


</script>
