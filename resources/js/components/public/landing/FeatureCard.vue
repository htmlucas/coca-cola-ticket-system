<script setup lang="ts">
import { Gift, MapPin, ShieldCheck, Ticket } from 'lucide-vue-next';
import { computed } from 'vue';
import type { CampaignFeature } from '@/config/campaign';
import { cn } from '@/lib/utils';

const props = defineProps<{
    title: string;
    description: string;
    icon: CampaignFeature['icon'];
    class?: string;
}>();

const iconComponent = computed(() => {
    const icons = {
        ticket: Ticket,
        gift: Gift,
        map: MapPin,
        shield: ShieldCheck,
    };

    return icons[props.icon];
});
</script>

<template>
    <article
        :class="
            cn(
                'group flex flex-col gap-4 rounded-2xl border border-border bg-card p-5 shadow-sm transition-shadow hover:shadow-md sm:p-6',
                props.class,
            )
        "
    >
        <div
            class="flex h-11 w-11 items-center justify-center rounded-xl bg-coke-red/10 text-coke-red transition-colors group-hover:bg-coke-red group-hover:text-white"
        >
            <component :is="iconComponent" class="h-5 w-5" aria-hidden="true" />
        </div>
        <div class="space-y-2">
            <h3 class="text-lg font-semibold tracking-tight">
                {{ title }}
            </h3>
            <p class="text-sm leading-relaxed text-muted-foreground">
                {{ description }}
            </p>
        </div>
    </article>
</template>
