<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PageHeading from '@/components/shared/PageHeading.vue';
import StatusBadge from '@/components/shared/StatusBadge.vue';
import { Button } from '@/components/ui/button';
import type { Paginated, StatusCount, TicketSummary } from '@/types';

defineProps<{
    totalTickets: number;
    statusCounts: StatusCount[];
    tickets: Paginated<TicketSummary>;
}>();
</script>

<template>
    <Head title="Histórico de tickets" />

    <PageHeading
        title="Histórico de tickets"
        description="Lista de tickets registrados na campanha."
    />

    <div class="mt-6 grid gap-3 md:grid-cols-4">
        <div class="rounded-md border border-border p-4">
            <p class="text-sm text-muted-foreground">Total registrado</p>
            <p class="mt-1 text-2xl font-semibold">{{ totalTickets }}</p>
        </div>
        <div
            v-for="item in statusCounts"
            :key="item.status"
            class="rounded-md border border-border p-4"
        >
            <p class="text-sm text-muted-foreground">{{ item.label }}</p>
            <p class="mt-1 text-2xl font-semibold">{{ item.total }}</p>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <Button as-child>
            <Link href="/app/tickets/register">Registrar ticket</Link>
        </Button>
    </div>

    <div class="mt-4 overflow-hidden rounded-md border border-border">
        <table class="w-full text-sm">
            <thead class="bg-muted/50 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium">Série</th>
                    <th class="px-4 py-3 font-medium">Cidade</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium">Registrado em</th>
                    <th class="px-4 py-3 font-medium">Comprovante</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="ticket in tickets.data"
                    :key="ticket.id"
                    class="border-t border-border"
                >
                    <td class="px-4 py-3 font-medium">
                        {{ ticket.serial_number }}
                    </td>
                    <td class="px-4 py-3">
                        {{ ticket.city.name }} / {{ ticket.city.state }}
                    </td>
                    <td class="px-4 py-3">
                        <StatusBadge
                            :status="ticket.status"
                            :label="ticket.status_label"
                        />
                        <p
                            v-if="ticket.rejection_reason"
                            class="mt-1 text-xs text-muted-foreground"
                        >
                            {{ ticket.rejection_reason }}
                        </p>
                    </td>
                    <td class="px-4 py-3">{{ ticket.created_at }}</td>
                    <td class="px-4 py-3">
                        <a
                            :href="ticket.proof_image_url"
                            target="_blank"
                            class="font-medium text-primary underline-offset-4 hover:underline"
                        >
                            Ver imagem
                        </a>
                    </td>
                </tr>
                <tr v-if="tickets.data.length === 0">
                    <td
                        colspan="5"
                        class="px-4 py-8 text-center text-muted-foreground"
                    >
                        Nenhum ticket registrado.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <nav
        v-if="tickets.links.length > 3"
        class="mt-4 flex flex-wrap gap-2"
        aria-label="Paginação"
    >
        <Link
            v-for="link in tickets.links"
            :key="link.label"
            :href="link.url ?? '#'"
            preserve-scroll
            class="rounded-md border px-3 py-2 text-sm"
            :class="[
                link.active
                    ? 'border-primary bg-primary text-primary-foreground'
                    : 'border-border',
                !link.url && 'pointer-events-none opacity-50',
            ]"
        >
            <span v-html="link.label" />
        </Link>
    </nav>
</template>
