<script setup>
import { computed } from "vue";
import { ToastDescription } from "radix-vue";
import { cn } from "@/lib/utils";

const props = defineProps({
  asChild: { type: Boolean, required: false },
  as: { type: null, required: false },
  class: { type: null, required: false },
});

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props;

  return delegated;
});
</script>

<template>
  <ToastDescription
    :class="cn('text-xs opacity-90', props.class)"
    v-bind="delegatedProps"
  >
    <slot />
  </ToastDescription>
</template>
