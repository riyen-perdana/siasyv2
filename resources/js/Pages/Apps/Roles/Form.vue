<script setup>
import { Button } from "@/shadcn/ui/button";
import Input from "@/shadcn/ui/input/Input.vue";
import { useForm, router } from "@inertiajs/vue3";
import { Checkbox } from "@/shadcn/ui/checkbox";
import { Label } from "@/shadcn/ui/label";
import { Icon } from "@iconify/vue";
import { Card, CardHeader, CardTitle, CardContent } from "@/shadcn/ui/card";
import { objectEntries } from "@vueuse/core";
import { nextTick, onMounted, ref, watchEffect, computed , onUnmounted } from "vue";

const form = useForm({
    nm_role: "",
    permission: [],
});

const props = defineProps({
    errors: Object,
    permissions: Object,
    data: Object,
});

const nm_role = ref(null);
// const permission = ref([]);

const submitData = () => {
    if(props.data?.name){
        router.put('/apps/otorisasi-aplikasi/' + props.data.id,
        form,
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                form.reset();
                form.clearErrors();
                emit('closeModal');
                emit('toastMessage',props.data?.id);
            },
            onError: () => {
                form.cancel,
                nextTick(() => nm_role.value.$el.focus());
            }
        });
    } else {
        router.post('/apps/otorisasi-aplikasi', 
        form,
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                form.reset();
                form.clearErrors();
                emit('closeModal');
                emit('toastMessage');
            },
            onError: () => {
                form.cancel,
                nextTick(() => nm_role.value.$el.focus());
            }
        });
    }
};

const emit = defineEmits(["closeModal"]);

onMounted(() => {
    nextTick(() => nm_role.value.$el.focus());
});

onUnmounted(() => {
    form.reset();
    props.errors.nm_role = '';
    props.errors.permission = '';
})

watchEffect(() => {
    if(props.data && props.data?.permissions !== undefined) {
        form.nm_role = props.data?.name;
        form.permission = props.data?.permissions.map((obj) => obj.name);
    }
});

const getPermission = computed(() => {
    return objectEntries(props.permissions).map(([group, permissionItems],i) => ({
        group: group,
        permissionItems: permissionItems,
        key: i
    }))
});

</script>

<template>
    <form @submit.prevent="submitData">
        <div class="grid grid-cols-1 gap-y-4">
            <div>
                <Label for="otoritas" class="mb-2 text-xs font-semibold"
                    >Otoritas Pengguna<span class="text-red-500">*</span></Label
                >
                <Input
                    id="nm_role"
                    type="text"
                    placeholder="Otoritas Pengguna"
                    name="nm_role"
                    class="text-xs ring-inset"
                    v-model="form.nm_role"
                    ref="nm_role"
                />
                <div
                    v-if="$page.props.errors.nm_role"
                    class="text-red-500 mt-1 text-xs"
                >
                    {{ $page.props.errors.nm_role }}
                </div>
            </div>
            <div>
                <Label for="permission" class="mb-2 text-xs font-semibold"
                    >Perizinan Aplikasi<span class="text-red-500">*</span></Label
                >
                <!-- <div class="grid grid-cols-1 gap-1 mt-2 md:grid-cols-4"> -->
                <div class="flex flex-col space-y-1 pt-1">
                    <!-- {{ getPermission }} -->
                    <div
                        class="flex items-center mb-2"
                        v-for="({group, permissionItems}, index) in getPermission"
                        :key="index"
                    >
                        <Card class="w-full">
                            <CardHeader>
                                <CardTitle class='text-xs capitalize'>{{ group }}</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div class="flex flex-row space-x-1 p-2">
                                    <div 
                                        class="flex items-center mb-2 me-4"
                                        v-for="permission in permissionItems" 
                                        :key="permission"
                                    >
                                        <input
                                            type="checkbox"
                                            :id="permission"
                                            :name="permission"
                                            :value="permission"
                                            v-model="form.permission"
                                        />
                                        <Label class="text-xs font-light p-1">
                                            {{ permission }}
                                        </Label>
                                    </div>
                                    <!-- <div
                                        class="flex items-center mb-2 me-4"
                                        v-for="permission in permissionItems"
                                        :key="permission"
                                    >
                                        <Checkbox
                                            id="permission"
                                            name="permission"
                                            class="peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground"
                                            :value="permission"
                                            v-model="form.permission"
                                        />
                                        <Label class="text-xs font-light p-1">
                                            {{ permission }}
                                        </Label>
                                    </div> -->
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                </div>
                <div
                    v-if="$page.props.errors.permission"
                    class="text-red-500 mt-1 text-xs"
                >
                    {{ $page.props.errors.permission }}
                </div>
            </div>
            <div class="flex justify-end">
                <Button type="submit" class="text-xs rounded-none h-9"
                    >Simpan
                    <Icon
                        :style="{
                            color: 'text-foreground',
                            'margin-left': '5px',
                        }"
                        :icon="'ri:save-line'"
                        :inline="true"
                        :height="'20'"
                    />
                </Button>
            </div>
        </div>
    </form>
</template>
