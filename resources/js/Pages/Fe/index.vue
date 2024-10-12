<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import setting from '@/lib/setting.js';
import { Icon } from '@iconify/vue';
import Button from '@/shadcn/ui/button/Button.vue';
import { Label } from '@/shadcn/ui/label';
import { Input } from '@/shadcn/ui/input';
import { Checkbox } from '@/shadcn/ui/checkbox';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Sheet, SheetContent, SheetTrigger, SheetClose, SheetHeader, SheetTitle, SheetDescription, SheetFooter } from '@/shadcn/ui/sheet';

const isDark = ref(false);
const passIsVisible = ref(false);

const changeMode = () => {
    isDark.value = !isDark.value
    console.log(isDark.value)
}

const togglePassword = () => {
    passIsVisible.value = !passIsVisible.value
    console.log(passIsVisible.value)
}

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

</script>

<template>

    <Head title="Beranda" />
    <FrontendLayout>
        <template #header>
            <div class="flex flex-row items-center gap-x-2">
                <img src="../../../../public/images/logo-uin.png" alt="" class="h-[60px]">
                <img src="../../../../public/images/siasy.png" alt="" class="hidden sm:block h-[70px] -mt-2">
                <div class="flex flex-col items-start gap-y-2">
                    <h3 class="text-2xl font-bold leading-none md:block lg:block text-indigo-950 font-['Lobster']">
                        {{ setting.setting.app_name }}
                    </h3>
                    <h3 class="text-sm font-semibold leading-none md:block lg:block text-indigo-950">
                        {{ setting.setting.fakultas }}
                    </h3>
                </div>
            </div>
            <div class="hidden lg:block">
                <!--Menu-->
                <div class="flex flex-row items-center gap-x-4">
                    <Link href="/"
                        class="text-sm font-semibold leading-none transition-colors hover:text-foreground/80 text-foreground/60">
                    Beranda</Link>
                    <a href="#"
                        class="text-sm font-semibold leading-none transition-colors hover:text-foreground/80 text-foreground/60">Pengumuman</a>
                    <a href="#"
                        class="text-sm font-semibold leading-none transition-colors hover:text-foreground/80 text-foreground/60">Panduan</a>
                    <a href="#"
                        class="text-sm font-semibold leading-none transition-colors hover:text-foreground/80 text-foreground/60">Lacak
                        Surat</a>
                    <Button variant="ghost" size="icon" @click="changeMode()">
                        <div v-if="isDark">
                            <Icon :style="{ color: 'black' }" icon="mdi:white-balance-sunny" :inline="true"
                                :height="'20'" />
                        </div>
                        <div v-else>
                            <Icon :style="{ color: 'black' }" icon="mdi:moon-and-stars" :inline="true" :height="'20'" />
                        </div>
                    </Button>
                </div>
            </div>
            <div class="lg:hidden">
                <Sheet>
                    <SheetTrigger as-child>
                        <Button variant="ghost" size="icon">
                            <Icon :style="{ color: 'black' }" icon="ci:hamburger-md" :inline="true" :height="'20'" />
                        </Button>
                    </SheetTrigger>
                    <SheetContent>
                        <SheetHeader>
                            <SheetTitle class="flex justify-items-start font-['Lobster'] text-2xl mb-2">
                                Siasy
                            </SheetTitle>
                            <div class="flex flex-col gap-y-4">
                                <Link
                                    class="flex justify-start font-semibold leading-none transition-colors hover:text-foreground/80 text-foreground/60"
                                    variant="ghost">Beranda</Link>
                                <Link
                                    class="flex justify-start font-semibold leading-none transition-colors hover:text-foreground/80 text-foreground/60"
                                    variant="ghost">Pengumuman</Link>
                                <Link
                                    class="flex justify-start font-semibold leading-none transition-colors hover:text-foreground/80 text-foreground/60"
                                    variant="ghost">Panduan</Link>
                                <Link
                                    class="flex justify-start font-semibold leading-none transition-colors hover:text-foreground/80 text-foreground/60"
                                    variant="ghost">Lacak Surat</Link>
                            </div>
                        </SheetHeader>
                    </SheetContent>
                </Sheet>
            </div>
        </template>
        <template #default>
            <div class="flex items-center justify-center h-full">
                <section name="jumbotron">
                    <div class="flex flex-row justify-between mx-2 gap-x-4">
                        <div class="flex-row items-center justify-center hidden w-2/3 mt-24 lg:block">
                            <h1
                                class="mb-1 text-[45px] font-bold leading-none md:block lg:block text-foreground/80 font-['Oswald'] tracking-tight">
                                Universitas Islam Negeri</h1>
                            <h2
                                class="text-4xl font-semibold leading-none md:block lg:block text-foreground/80 font-['Oswald'] tracking-tight">
                                Sultan Syarif Kasim Riau</h2>
                            <h2
                                class="mt-5 text-3xl font-semibold leading-none md:block lg:block text-green-600 font-['Oswald'] tracking-tight">
                                {{ setting.setting.fakultas }}</h2>
                            <p
                                class="mt-1 text-3xl font-normal leading-none md:block lg:block text-foreground/80 font-['Lobster'] tracking-tight">
                                Berkarya <span class="text-red-600">Gemilang</span> & Berprestasi <span
                                    class="text-yellow-500">Terbilang</span></p>
                        </div>
                        <div class="flex-row items-center justify-center w-full lg:w-1/3 lg:block">
                            <div class="flex flex-col justify-center w-full mx-auto space-y-6">
                                <div class="flex flex-col space-y-2">
                                    <div>
                                        <h1 class="text-xl font-semibold leading-tight tracking-tight">
                                            Assalamualaikum Civitas Akademika {{ setting.setting.fakultas }}
                                        </h1>
                                        <p class="text-sm font-semibold text-muted-foreground">Untuk menggunakan
                                            aplikasi Siasy, silahkan login di sini 👋</p>
                                    </div>
                                    <p class="text-sm text-muted-foreground">
                                        Aplikasi Siasy terintegrasi dengan iRaise, silahkan masukkan username dan
                                        password anda sesuai iRaise.
                                    </p>
                                    <div>
                                        <div class="grid gap-6 mt-3">
                                            <form>
                                                <div class="grid gap-2">
                                                    <div class="grid gap-1">
                                                        <Label for="username"
                                                            class="mb-2 font-semibold">Username</Label>
                                                        <Input
                                                            id="username"
                                                            type="text"
                                                            placeholder="Username Sesuai iRaise"
                                                            name="username"
                                                            v-model="form.username" />
                                                    </div>
                                                    <div class="grid gap-1">
                                                        <Label for="password"
                                                            class="mb-2 font-semibold">Password</Label>
                                                        <div class="relative">
                                                            <Input id="password"
                                                                :type="passIsVisible ? 'text' : 'password'"
                                                                placeholder="Password Sesuai iRaise"
                                                                name="password"
                                                                v-model="form.password" />
                                                            <span
                                                                class="absolute inset-y-0 right-0 flex items-center pr-1">
                                                                <Button variant="link" size="icon"
                                                                    @click.prevent="togglePassword()">
                                                                    <Icon :style="{ color: 'text-foreground' }"
                                                                        :icon="passIsVisible ? 'mdi:eye-off-outline' : 'mdi:eye-outline'"
                                                                        :inline="true" :height="'20'" />
                                                                </Button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-row items-center justify-between mt-2 mb-2">
                                                        <div class="flex flex-row items-center space-x-2">
                                                            <Checkbox id="remember" v-model="form.remember" />
                                                            <label for="remember" class="text-xs font-semibold leading-none text-foreground/60 peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                                                Ingat Saya</label>
                                                        </div>
                                                        <div >
                                                            <Link
                                                                class="text-xs font-semibold leading-none transition-colors hover:text-foreground/80 text-foreground/60"
                                                                variant="ghost">Lupa Password ??
                                                            </Link>
                                                        </div>

                                                    </div>
                                                    <Button variant="default" type="submit">
                                                        Masuk
                                                        <Icon
                                                            :style="{ color: 'text-foreground', 'margin-left': '5px' }"
                                                            :icon="'ion:enter-outline'"
                                                            :inline="true" :height="'20'" />
                                                    </Button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </template>
        <template #footer>
            <div class="mt-3 mb-3 text-xs font-semibold leading-none text-foreground/60">
                © {{ new Date().getFullYear() }} {{ setting.setting.app_dev }} - {{ setting.setting.app_inst }}
            </div>
        </template>
    </FrontendLayout>
</template>
