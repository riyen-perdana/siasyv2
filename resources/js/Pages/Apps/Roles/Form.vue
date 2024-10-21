<script setup>
import { Button } from '@/shadcn/ui/button';
import Input from '@/shadcn/ui/input/Input.vue';
import { useForm } from '@inertiajs/vue3';
import { Checkbox } from '@/shadcn/ui/checkbox';
import { Label } from '@/shadcn/ui/label';
import { Icon } from '@iconify/vue';

const form = useForm({
    nm_role: '',
    permission: []
});

const props = defineProps({
    errors: Object,
    permissions: Object
});

const submitData = () => {
    emit('closeModal');
}

const emit = defineEmits(['closeModal']);

</script>

<template>
    <form @submit.prevent="submitData">
        <div class="grid grid-cols-1 gap-y-4">
            <div>
                <Label for="otoritas" class="mb-2 text-xs font-semibold">Otoritas Pengguna*</Label>
                <Input id="nm_role" type="text" placeholder="Otoritas Pengguna" name="nm_role"
                    class="text-xs ring-inset" v-model="form.nm_role" />
                <div v-if="$page.props.errors.otoritas" class="text-red-500 mt-1text-xs">
                    {{ $page.props.errors.nm_role }}
                </div>
            </div>
            <div>
                <Label for="permission" class="mb-2 text-xs font-semibold">Perizinan Aplikasi*</Label>
                <div class="grid grid-cols-1 gap-1 mt-2 md:grid-cols-4">
                    <div class="flex items-center mb-2 me-4" v-for="(permission, index) in permissions" :key="index">
                        <Checkbox id="permission" name="permission" class="mr-1 text-xs ring-inset" :value="permission.name"
                            v-model="form.permission" />
                        <Label class="text-xs font-light">{{ permission.name }}</Label>
                    </div>
                </div>
                <div v-if="$page.props.errors.permission" class="text-red-500 mt-1text-xs">
                    {{ $page.props.errors.permission }}
                </div>
            </div>
            <div class="flex justify-end">
                <Button type="submit" class="text-xs rounded-none h-9">Simpan
                    <Icon :style="{ color: 'text-foreground', 'margin-left': '5px' }"
                    :icon="'ri:save-line'" :inline="true" :height="'20'" />
                </Button>
            </div>
        </div>
    </form>
</template>
