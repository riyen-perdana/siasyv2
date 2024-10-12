<template>
    <Head title="Login Petugas" />
    <LoginLayout>
        <div class="grid gap-6 mt-3">
            <form @submit.prevent="submit">
                <div class="grid gap-1">
                    <div class="grid">
                        <Label for="username" class="mb-2 font-normal text-[13px]">Nomor Induk ASN</Label>
                        <Input autofocus id="nip" type="text" placeholder="Nomor Induk ASN" name="nip" v-model="form.nip" ref="refInput"
                            class="text-[13px] ring-inset" />
                    </div>
                    <div class="grid mt-2">
                        <Label for="password" class="mb-2 font-normal text-[13px]">Kata Kunci</Label>
                        <div class="relative">
                            <Input id="password" :type="passIsVisible ? 'text' : 'password'" placeholder="Kata Kunci"
                                name="password" v-model="form.password" class="text-[13px] ring-inset" />
                            <span class="absolute inset-y-0 right-0 flex items-center pr-1">
                                <Button variant="link" size="icon" @click.prevent="togglePassword()" class="mr-2 focus:outline-none">
                                    <Icon :style="{ color: 'text-foreground' }"
                                        :icon="passIsVisible ? 'mdi:eye-outline' : 'mdi:eye-off-outline'" :inline="true"
                                        :height="'20'" />
                                </Button>
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-row items-center justify-between mt-2 mb-2">
                        <div class="flex flex-row items-center space-x-2">
                            <Checkbox id="remember" :checked="form.remember" @update:checked="form.remember = $event" class="focus:outline-none focus:ring-0 focus:ring-offset-0"/>
                            <label for="remember"
                                class="text-xs font-normal leading-none text-foreground/60 peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                Ingat Saya</label>
                        </div>
                        <div>
                            <Link :href="route('lupa-password')"
                                class="text-xs font-normal leading-none transition-colors hover:text-foreground/80 text-foreground/60 hover:underline focus:outline-none focus:underline"
                                variant="ghost">Lupa Kata Kunci ??
                            </Link>
                        </div>
                    </div>
                    <Button variant="default" type="submit">
                        Masuk
                        <Icon :style="{ color: 'text-foreground', 'margin-left': '5px' }" :icon="'ion:enter-outline'"
                            :inline="true" :height="'20'" />
                    </Button>
                </div>
            </form>
        </div>
    </LoginLayout>
    <Toaster />
</template>

<script setup>
import { nextTick, onMounted, ref } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import LoginLayout from '@/Layouts/LoginLayout.vue';
import { Icon } from '@iconify/vue';
import { Button } from '@/shadcn/ui/button';
import { Label } from '@/shadcn/ui/label';
import { Input } from '@/shadcn/ui/input';
import { Checkbox } from '@/shadcn/ui/checkbox';
import { useToast } from '@/shadcn/ui/toast/use-toast';
import { Toaster } from '@/shadcn/ui/toast';

const form = useForm({
    nip: '',
    password: '',
    remember: false,
});

const props = defineProps({
    errors: Object,
});

const refInput = ref(null);

const { toast } = useToast();
const passIsVisible = ref(false);
const togglePassword = () => {
    passIsVisible.value = !passIsVisible.value
    console.log(passIsVisible.value)
}

const clearData = () => {
    form.reset('nip', 'password', 'remember');
    nextTick(() => refInput.value.$el.focus());
}

onMounted(() => {
    refInput.value.$el.focus();
});

const submit = () => {
    console.log(form.nip, form.password, form.remember);
    form.post(route('login'), {
        nip: form.nip,
        password: form.password,
        remember: form.remember,
        onError: () => {
            if (form.errors?.nip) {
                toast({
                    title: 'Ups, Proses Login Anda Bermasalah',
                    description: 'Pastikan Nomor Induk ASN dan kata kunci anda sudah benar, atau silahkan hubungi Administrator.',
                    variant: 'destructive',
                });
                clearData();
            }
        }
    });
};
</script>
