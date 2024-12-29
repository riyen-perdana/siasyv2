<script setup>
import { Button } from '@/shadcn/ui/button';
import Input from '@/shadcn/ui/input/Input.vue';
import { useForm } from '@inertiajs/vue3';
import { Label } from '@/shadcn/ui/label';
import { Icon } from '@iconify/vue';

const form = useForm({
    'nm_perizinan': '',
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
                <Label for="otoritas" class="mb-2 text-xs font-normal">Perizinan Pengguna <span class="text-red-500">*</span></Label>
                <Input id="nm_perizinan" type="text" placeholder="Perizinan Pengguna" name="nm_perizinan"
                    class="text-xs ring-inset" v-model="form.nm_perizinan" />
                <div v-if="$page.props.errors.permission" class="text-red-500 mt-1 text-xs">
                    {{ $page.props.errors.nm_role }}
                </div>
            </div>
            <div class="flex justify-end">
                <Button type="submit" class="text-xs font-normal rounded-none h-9 bg-neutral-800">Simpan
                    <Icon :style="{ color: 'text-foreground', 'margin-left': '5px' }"
                    :icon="'ri:save-line'" :inline="true" :height="'20'" />
                </Button>
            </div>
        </div>
    </form>
</template>
