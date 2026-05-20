<script setup lang="ts">
import { computed } from 'vue';
import { Badge } from '@/components/ui/badge';
import { cn } from '@/lib/utils';
import type { TicketStatus } from '@/types';

const props = defineProps<{
    status: TicketStatus;
    label: string;
}>();

const statusClass = computed(() => {
    return {
        pending: 'border-amber-200 bg-amber-50 text-amber-700',
        approved: 'border-emerald-200 bg-emerald-50 text-emerald-700',
        rejected: 'border-red-200 bg-red-50 text-red-700',
    }[props.status];
});
</script>

<template>
    <Badge variant="outline" :class="cn(statusClass)">
        {{ label }}
    </Badge>
</template>
