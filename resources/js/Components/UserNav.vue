<script setup>
import {
  Avatar,
  AvatarFallback,
  AvatarImage,
} from '@/shadcn/ui/avatar';
import { Button } from '@/shadcn/ui/button';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuShortcut,
  DropdownMenuTrigger,
} from '@/shadcn/ui/dropdown-menu';
import { Link } from '@inertiajs/vue3';

</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="ghost" class="relative w-8 h-8 rounded-full">
        <Avatar class="w-8 h-8">
          <AvatarImage :src="`https://ui-avatars.com/api/?name=${$page.props.auth.user?.name}&amp;background=4e73df&amp;color=ffffff&amp;`" alt="@shadcn" />
          <AvatarFallback></AvatarFallback>
        </Avatar>
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent class="w-56" align="end">
      <DropdownMenuLabel class="flex font-normal">
        <div class="flex flex-col space-y-1">
          <p class="text-sm font-medium leading-none">
            {{ $page.props.auth?.user?.full_nm_user }}
          </p>
          <p class="text-xs font-medium leading-none">
            {{ $page.props.auth?.roles }}
          </p>
          <p class="text-xs leading-none text-muted-foreground">
            {{ $page.props.auth?.user?.email }}
          </p>
        </div>
      </DropdownMenuLabel>
      <DropdownMenuSeparator />
      <DropdownMenuGroup>
        <DropdownMenuItem class="text-[13px]">
          Profile
        </DropdownMenuItem>
        <DropdownMenuItem class="text-[13px]">
          Settings
        </DropdownMenuItem>
      </DropdownMenuGroup>
      <DropdownMenuSeparator />
      <DropdownMenuItem class="text-[13px]">
        <Link :href="route('logout')" method="post" as="button">
            Log out
        </Link>
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
