<template>
    <Menubar class="flex items-center space-x-2 border-none rounded-none lg:space-x-2 text-[13px]">
        <MenubarMenu>
            <MenubarTrigger><Link :href="route('dashboard')" class="text-[13px] font-medium">Dashboard</Link></MenubarTrigger>
        </MenubarMenu>
        <MenubarMenu>
            <MenubarTrigger class="text-[13px] font-medium">Authentikasi</MenubarTrigger>
            <MenubarContent>
                <MenubarItem class="text-[13px]"><Link :href="route('apps.permission.index')">Perizinan Aplikasi</Link></MenubarItem>
                <MenubarItem class="text-[13px]">Otorisasi Aplikasi</MenubarItem>
                <MenubarItem class="text-[13px]">Pengguna</MenubarItem>
                <MenubarSeparator />
                <MenubarItem class="text-[13px]">Mahasiswa</MenubarItem>
            </MenubarContent>
        </MenubarMenu>
        <MenubarMenu>
            <MenubarTrigger>View</MenubarTrigger>
            <MenubarContent>
                <MenubarCheckboxItem>Always Show Bookmarks Bar</MenubarCheckboxItem>
                <MenubarCheckboxItem checked>
                    Always Show Full URLs
                </MenubarCheckboxItem>
                <MenubarSeparator />
                <MenubarItem inset>
                    Reload <MenubarShortcut>⌘R</MenubarShortcut>
                </MenubarItem>
                <MenubarItem disabled inset>
                    Force Reload <MenubarShortcut>⇧⌘R</MenubarShortcut>
                </MenubarItem>
                <MenubarSeparator />
                <MenubarItem inset>
                    Toggle Fullscreen
                </MenubarItem>
                <MenubarSeparator />
                <MenubarItem inset>
                    Hide Sidebar
                </MenubarItem>
            </MenubarContent>
        </MenubarMenu>
        <MenubarMenu>
            <MenubarTrigger>Profiles</MenubarTrigger>
            <MenubarContent>
                <MenubarRadioGroup value="benoit">
                    <MenubarRadioItem value="andy">
                        Andy
                    </MenubarRadioItem>
                    <MenubarRadioItem value="benoit">
                        Benoit
                    </MenubarRadioItem>
                    <MenubarRadioItem value="Luis">
                        Luis
                    </MenubarRadioItem>
                </MenubarRadioGroup>
                <MenubarSeparator />
                <MenubarItem inset>
                    Edit...
                </MenubarItem>
                <MenubarSeparator />
                <MenubarItem inset>
                    Add Profile...
                </MenubarItem>
            </MenubarContent>
        </MenubarMenu>
    </Menubar>
</template>

<script setup>
import {
    Menubar,
    MenubarCheckboxItem,
    MenubarContent,
    MenubarItem,
    MenubarLabel,
    MenubarMenu,
    MenubarRadioGroup,
    MenubarRadioItem,
    MenubarSeparator,
    MenubarShortcut,
    MenubarSub,
    MenubarSubContent,
    MenubarSubTrigger,
    MenubarTrigger,
} from '@/shadcn/ui/menubar';
import { Link } from '@inertiajs/vue3';

</script>
