<template>
    <Head title="Lupa Kata Kunci" />
    <LoginLayout>
        <div class="mb-4 text-xs text-gray-600 dark:text-gray-400">
            Anda lupa kata kunci? Tidak masalah. Kami akan mengirimkan email reset password ke email anda.
        </div>
        <div class="grid gap-6 mt-3">
            <form>
                <div class="grid gap-1">
                    <div class="grid">
                        <Label for="txtEmail" class="mb-2 font-normal text-[13px]">Email ASN</Label>
                        <Input id="txtEmail" type="email" placeholder="Email ASN" name="email" v-model="form.email"
                            class="text-xs ring-inset" />
                    </div>
                    <div class="flex flex-row items-end justify-end mt-2 mb-2">
                        <div>
                            <Link :href="route('login-petugas')"
                                class="text-xs font-normal leading-none transition-colors hover:underline hover:text-foreground/80 text-foreground/60 focus:outline-none focus:text-foreground/60 focus:underline"
                                variant="ghost">Kembali Ke Halaman Login
                            </Link>
                        </div>
                    </div>
                    <Button variant="default" type="submit" class="outline-none focus:ring-transparent">
                        Kirim Email
                        <Icon :style="{ color: 'text-foreground', 'margin-left': '5px' }" :icon="'mdi:email-send-outline'"
                            :inline="true" :height="'20'" />
                    </Button>
                </div>
            </form>
        </div>
    </LoginLayout>
</template>

<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import LoginLayout from '@/Layouts/LoginLayout.vue';
import { Icon } from '@iconify/vue';
import { Button } from '@/shadcn/ui/button';
import { Label } from '@/shadcn/ui/label';
import { Input } from '@/shadcn/ui/input';

const form = useForm({
    email : '',
});

</script>
