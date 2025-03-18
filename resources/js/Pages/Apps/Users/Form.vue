<template>
    <form @submit.prevent="submitData">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <Label for="nip" class="mb-2 text-xs font-normal">
                    NIP PNS/PPPK
                    <span class="text-red-500">*</span>
                </Label>
                <Input
                    id="nip"
                    v-model="form.nip"
                    type="text"
                    class="text-xs ring-inset block w-full"
                    ref="nip"
                    placeholder="Contoh: 198111162011012001"
                />
                <div
                    v-if="$page.props.errors.nip"
                    class="text-red-500 mt-1 text-xs"
                >
                    {{ $page.props.errors.nip }}
                </div>
            </div>
            <div>
                <Label for="name" class="mb-2 text-xs font-normal">
                    Nama PNS/PPPK
                    <span class="text-red-500">*</span>
                </Label>
                <Input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="text-xs ring-inset block w-full"
                    placeholder="Contoh: Shuzhisni Ade Permana Putra"
                />
                <div
                    v-if="$page.props.errors.nip"
                    class="text-red-500 mt-1 text-xs"
                >
                    {{ $page.props.errors.nip }}
                </div>
            </div>
            <div>
                <Label for="glr_dpn" class="mb-2 text-xs font-normal">
                    Gelar Depan <span class="italic text-red-500">[Kosongkan jika tidak ada]</span>
                </Label>
                <Input
                    id="glr_dpn"
                    v-model="form.glr_dpn"
                    type="text"
                    class="text-xs ring-inset block w-full"
                    placeholder="Contoh: Prof., Dr.,"
                />
                <div
                    v-if="$page.props.errors.glr_dpn"
                    class="text-red-500 mt-1 text-xs"
                >
                    {{ $page.props.errors.glr_dpn }}
                </div>
            </div>
            <div>
                <Label for="glr_blk" class="mb-2 text-xs font-normal">
                    Gelar Belakang <span class="italic text-red-500">[Kosongkan jika tidak ada]</span>
                </Label>
                <Input
                    id="glr_blk"
                    v-model="form.glr_blk"
                    type="text"
                    class="text-xs ring-inset block w-full"
                    placeholder="Contoh: S.Kom.,M.Kom"
                />
                <div
                    v-if="$page.props.errors.glr_blk"
                    class="text-red-500 mt-1 text-xs"
                >
                    {{ $page.props.errors.glr_blk }}
                </div>
            </div>
            <div>
                <Label for="email" class="mb-2 text-xs font-normal">
                    Email
                    <span class="text-red-500">*</span>
                </Label>
                <Input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="text-xs ring-inset block w-full"
                    placeholder="Contoh: shuzisni@uin-suska.ac.id"
                />
                <div
                    v-if="$page.props.errors.email"
                    class="text-red-500 mt-1 text-xs"
                >
                    {{ $page.props.errors.email }}
                </div>
            </div>
            <div>
                <Label for="role" class="mb-2 text-xs font-normal">
                    Authentikasi
                    <span class="text-red-500">*</span>
                </Label>
                <Select
                    :model-value="form.role"
                    @update:model-value="form.role = $event"
                >
                    <SelectTrigger
                        class="text-xs rounded-none h-9 focus:ring-0 ring-inset"
                        name="role"
                    >
                        <SelectValue placeholder="Pilih Authentikasi" />
                    </SelectTrigger>
                    <SelectContent class="text-[13px] rounded-none focus:ring-0">
                        <SelectGroup>
                            <SelectItem v-for="role in props.roles" :key="role.id" :value="role.id" class="text-xs">
                                {{ role.name }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <div
                    v-if="$page.props.errors.role"
                    class="text-red-500 mt-1 text-xs"
                >
                    {{ $page.props.errors.role }}
                </div>
            </div>
            <div>
                <Label for="password" class="mb-2 text-xs font-normal">
                    Kata Kunci
                    <span class="text-red-500">*</span>
                </Label>
                <Input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="text-xs ring-inset block w-full"
                />
                <div
                    v-if="$page.props.errors.password"
                    class="text-red-500 mt-1 text-xs"
                >
                    {{ $page.props.errors.password }}
                </div>
            </div>
            <div>
                <Label for="password" class="mb-2 text-xs font-normal">
                    Konfirmasi Kata Kunci
                    <span class="text-red-500">*</span>
                </Label>
                <Input
                    id="role"
                    v-model="form.role"
                    type="text"
                    class="mt-1 block w-full"
                />
                <FormError :name="role" />
            </div>
            <div>
                <Label for="is_aktif" value="Status Aktif" />
                <Input
                    id="is_aktif"
                    v-model="form.is_aktif"
                    type="text"
                    class="mt-1 block w-full"
                />
                <FormError :name="is_aktif" />
            </div>
            <div>
                <Label for="jbtn" value="Jabatan" />
                <Input
                    id="jbtn"
                    v-model="form.jbtn"
                    type="text"
                    class="mt-1 block w-full"
                />
                <FormError :name="jbtn" />
            </div>
        </div>
        <div class="flex justify-end">
            <Button type="submit" class="mt-4"> Submit </Button>
        </div>
    </form>
</template>

<script setup>
import { Button } from "@/shadcn/ui/button";
import Input from "@/shadcn/ui/input/Input.vue";
import { useForm, router } from "@inertiajs/vue3";
import { Label } from "@/shadcn/ui/label";
import { Icon } from "@iconify/vue";
import { onUnmounted, nextTick, ref, onMounted, watchEffect } from "vue";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/shadcn/ui/select";

const props = defineProps({
    errors: Object,
    data: Object,
    roles: Object,
});

const emit = defineEmits(["closeModal", "toastMessage"]);

const form = useForm({
    nip: "",
    name: "",
    glr_dpn: "",
    glr_blk: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: "",
    is_aktif: ""
});
</script>
