<template>
    <div class="flex flex-row justify-between text-center gap-y-2">
        <div class="text-[13px] text-muted-foreground mt-4">
            Menampilkan data {{ props.count.from }} sampai {{ props.count.to }} dari {{ props.count.total }} data
        </div>
        <div class="text-[10px] text-muted-foreground mt-3">
            <Pagination v-slot="{ page }" :total="total" :sibling-count="1" show-edges :default-page="1" class="text-xs">
                <PaginationList v-slot="{ items }" class="flex items-center gap-1">
                    <!-- <PaginationFirst class="w-8 h-8 p-0" />
                    <PaginationPrev class="w-8 h-8 p-0" /> -->

                    <template v-for="(item, index ) in props.links">
                        <!-- {{ item }} -->
                        <PaginationListItem v-if="item.label != 'null'" :index="index" :value="item.label">
                            <Button class="h-8 p-0 text-xs border-none min-w-8" :variant="item.active === true ? 'default' : 'outline'">
                                <div v-if="props.search === null">
                                    <Link preserve-scroll v-html="item.label" :href="item.url === null ? '#' : item.url+'&perPage='+perPage"></Link>
                                </div>
                                <div v-else>
                                    <Link preserve-scroll v-html="item.label" :href="item.url === null ? '#' : item.url+'&perPage='+perPage+'&search='+search"></Link>
                                </div>
                            </Button>
                        </PaginationListItem>
                        <PaginationEllipsis v-else :index="index" />
                    </template>

                    <!-- <PaginationNext class="w-8 h-8 p-0" />
                    <PaginationLast class="w-8 h-8 p-0"/> -->
                </PaginationList>
            </Pagination>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import {
  Pagination,
  PaginationEllipsis,
  PaginationFirst,
  PaginationLast,
  PaginationList,
  PaginationListItem,
  PaginationNext,
  PaginationPrev,
} from '@/shadcn/ui/pagination';
import Button from '@/shadcn/ui/button/Button.vue';
import { computed } from 'vue';
const props = defineProps({
    count: Object,
    perPage: String,
    links: Object,
    search: String
});
const total = computed(() => {
    let total = Math.ceil(props.count.total/Number(props.perPage))*10;
    return total.toString();
})
</script>
