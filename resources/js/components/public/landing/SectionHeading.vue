<script setup lang="ts">
import { cn } from '@/lib/utils';

const props = withDefaults(
    defineProps<{
        eyebrow?: string;
        title: string;
        description?: string;
        align?: 'left' | 'center';
        class?: string;
    }>(),
    {
        align: 'left',
    },
);
</script>

<template>
    <div
        :class="
            cn(
                'max-w-2xl space-y-3',
                props.align === 'center' && 'mx-auto text-center',
                props.class,
            )
        "
    >
        <p
            v-if="eyebrow"
            class="text-xs font-semibold tracking-widest text-coke-red uppercase"
        >
            {{ eyebrow }}
        </p>
        <h2
            class="text-2xl font-bold tracking-tight text-balance sm:text-3xl lg:text-4xl"
        >
            {{ title }}
        </h2>
        <p
            v-if="description"
            class="text-base leading-relaxed text-muted-foreground sm:text-lg"
        >
            {{ description }}
        </p>
    </div>
</template>
