<script setup lang="ts">
import { cn } from '@/lib/utils';

defineProps<{
    class?: string;
    id?: string;
}>();
</script>

<template>
    <section :id="id" :class="cn('w-full', $props.class)">
        <div class="mx-auto w-full max-w-6xl px-4 md:px-6 lg:px-8">
            <slot />
        </div>
    </section>
</template>
