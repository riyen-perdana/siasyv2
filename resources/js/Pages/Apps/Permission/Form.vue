<script setup>
import { Button } from '@/shadcn/ui/button';
import Input from '@/shadcn/ui/input/Input.vue';
import { useForm, router } from '@inertiajs/vue3';
import { Label } from '@/shadcn/ui/label';
import { Icon } from '@iconify/vue';
import { onUnmounted, nextTick, ref, onMounted } from 'vue';

const props = defineProps({
    errors: Object
});

const nm_perizinan = ref(null);

const form = useForm({
    'nm_perizinan' : '',
});

const submitData = () => {
    router.post('/apps/perizinan-aplikasi', 
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
                nextTick(() => nm_perizinan.value.$el.focus());
                }
        });
}

const emit = defineEmits(['closeModal','toastMessage']);

onUnmounted(() => {
    form.reset();
    props.errors.nm_perizinan = '';
})

onMounted(() => {
    nextTick(() => nm_perizinan.value.$el.focus());
});

</script>

<template>
    <form @submit.prevent="submitData">
        <div class="grid grid-cols-1 gap-y-4">
            <div>
                <Label for="otoritas" class="mb-2 text-xs font-normal">Nama Perizinan<span class="text-red-500">*</span></Label>
                <Input id="nm_perizinan" type="text" placeholder="Nama Perizinan" name="nm_perizinan" ref="nm_perizinan"
                    class="text-xs ring-inset" v-model="form.nm_perizinan" />
                <div v-if="$page.props.errors.nm_perizinan" class="text-red-500 mt-1 text-xs">
                    {{ $page.props.errors.nm_perizinan }}
                </div>
            </div>
            <div class="flex justify-end">
                <Button type="submit" class="text-xs font-normal rounded-none h-9 bg-neutral-800" :disabled="form.processing">Simpan
                    <Icon :style="{ color: 'text-foreground', 'margin-left': '5px' }"
                    :icon="'ri:save-line'" :inline="true" :height="'20'" />
                </Button>
            </div>
        </div>
    </form>
</template>
