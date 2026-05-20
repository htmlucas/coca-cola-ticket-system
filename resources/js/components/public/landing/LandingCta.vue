<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { cn } from '@/lib/utils';

type Variant = 'primary' | 'secondary' | 'ghost' | 'inverse';

const props = withDefaults(
    defineProps<{
        href: string;
        label: string;
        variant?: Variant;
        class?: string;
    }>(),
    {
        variant: 'primary',
    },
);

const variantClasses: Record<Variant, string> = {
    primary:
        'bg-coke-red text-white shadow-lg shadow-coke-red/25 hover:bg-coke-red-dark focus-visible:ring-coke-red',
    secondary:
        'border-2 border-white/80 bg-white/10 text-white backdrop-blur-sm hover:bg-white/20 focus-visible:ring-white',
    ghost: 'border border-border bg-background text-foreground hover:bg-muted focus-visible:ring-ring',
    inverse:
        'bg-white text-coke-red shadow-lg shadow-black/10 hover:bg-white/90 focus-visible:ring-white',
};
</script>

<template>
    <Link
        :href="href"
        :class="
            cn(
                'inline-flex min-h-11 items-center justify-center rounded-full px-6 py-2.5 text-sm font-semibold transition-colors focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none sm:min-h-12 sm:px-8 sm:text-base',
                variantClasses[variant],
                props.class,
            )
        "
    >
        {{ label }}
    </Link>
</template>
