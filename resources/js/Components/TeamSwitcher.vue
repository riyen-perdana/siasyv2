<script setup lang="ts">
import { ref } from 'vue'
// import CaretSortIcon from '~icons/radix-icons/caret-sort'
// import CheckIcon from '~icons/radix-icons/check'
// import PlusCircledIcon from '~icons/radix-icons/plus-circled'

import { cn } from '@/lib/utils'
import {
  Avatar,
  AvatarFallback,
  AvatarImage,
} from '@/shadcn/ui/avatar';
import { Button } from '@/shadcn/ui/button';

import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/shadcn/ui/dialog';
import { Command, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList, CommandSeparator } from '@/shadcn/ui/command';
import { Input } from '@/shadcn/ui/input';
import { Label } from '@/shadcn/ui/label';
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/shadcn/ui/popover';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/shadcn/ui/select';

const groups = [
  {
    label: 'Personal Account',
    teams: [
      {
        label: 'Alicia Koch',
        value: 'personal',
      },
    ],
  },
  {
    label: 'Teams',
    teams: [
      {
        label: 'Acme Inc.',
        value: 'acme-inc',
      },
      {
        label: 'Monsters Inc.',
        value: 'monsters',
      },
    ],
  },
]

type Team = (typeof groups)[number]['teams'][number]

const open = ref(false)
const showNewTeamDialog = ref(false)
const selectedTeam = ref<Team>(groups[0].teams[0])
</script>

<template>
  <Dialog v-model:open="showNewTeamDialog">
    <Popover v-model:open="open">
      <PopoverTrigger as-child>
        <Button
          variant="outline"
          role="combobox"
          aria-expanded="open"
          aria-label="Select a team"
          :class="cn('w-[200px] justify-between', $attrs.class ?? '')"
        >
          <Avatar class="w-5 h-5 mr-2">
            <AvatarImage
              :src="`https://avatar.vercel.sh/${selectedTeam.value}.png`"
              :alt="selectedTeam.label"
            />
            <AvatarFallback>SC</AvatarFallback>
          </Avatar>
          {{ selectedTeam.label }}
          <CaretSortIcon class="w-4 h-4 ml-auto opacity-50 shrink-0" />
        </Button>
      </PopoverTrigger>
      <PopoverContent class="w-[200px] p-0">
        <Command :filter-function="(list, term) => list.filter(i => i.label?.toLowerCase()?.includes(term)) ">
          <CommandList>
            <CommandInput placeholder="Search team..." />
            <CommandEmpty>No team found.</CommandEmpty>
            <CommandGroup v-for="group in groups" :key="group.label" :heading="group.label">
              <CommandItem
                v-for="team in group.teams"
                :key="team.value"
                :value="team"
                class="text-sm"
                @select="() => {
                  selectedTeam = team
                  open = false
                }"
              >
                <Avatar class="w-5 h-5 mr-2">
                  <AvatarImage
                    :src="`https://avatar.vercel.sh/${team.value}.png`"
                    :alt="team.label"
                    class="grayscale"
                  />
                  <AvatarFallback>SC</AvatarFallback>
                </Avatar>
                {{ team.label }}
                <CheckIcon
                  :class="cn('ml-auto h-4 w-4',
                             selectedTeam.value === team.value
                               ? 'opacity-100'
                               : 'opacity-0',
                  )"
                />
              </CommandItem>
            </CommandGroup>
          </CommandList>
          <CommandSeparator />
          <CommandList>
            <CommandGroup>
              <DialogTrigger as-child>
                <CommandItem
                  value="create-team"
                  @select="() => {
                    open = false
                    showNewTeamDialog = true
                  }"
                >
                  <PlusCircledIcon class="w-5 h-5 mr-2" />
                  Create Team
                </CommandItem>
              </DialogTrigger>
            </CommandGroup>
          </CommandList>
        </Command>
      </PopoverContent>
    </Popover>
    <DialogContent>
      <DialogHeader>
        <DialogTitle>Create team</DialogTitle>
        <DialogDescription>
          Add a new team to manage products and customers.
        </DialogDescription>
      </DialogHeader>
      <div>
        <div class="py-2 pb-4 space-y-4">
          <div class="space-y-2">
            <Label for="name">Team name</Label>
            <Input id="name" placeholder="Acme Inc." />
          </div>
          <div class="space-y-2">
            <Label for="plan">Subscription plan</Label>
            <Select>
              <SelectTrigger>
                <SelectValue placeholder="Select a plan" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="free">
                  <span class="font-medium">Free</span> -
                  <span class="text-muted-foreground">
                    Trial for two weeks
                  </span>
                </SelectItem>
                <SelectItem value="pro">
                  <span class="font-medium">Pro</span> -
                  <span class="text-muted-foreground">
                    $9/month per user
                  </span>
                </SelectItem>
              </SelectContent>
            </Select>
          </div>
        </div>
      </div>
      <DialogFooter>
        <Button variant="outline" @click="showNewTeamDialog = false">
          Cancel
        </Button>
        <Button type="submit">
          Continue
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
