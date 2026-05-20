<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import PageHeading from '@/components/shared/PageHeading.vue';
import StatusBadge from '@/components/shared/StatusBadge.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import type {
    CityOption,
    Paginated,
    StatusOption,
    TicketSummary,
} from '@/types';

const props = defineProps<{
    tickets: Paginated<TicketSummary>;
    filters: {
        search: string;
        status: string;
        city_id: string;
    };
    statuses: StatusOption[];
    cities: CityOption[];
}>();

function approve(ticket: TicketSummary): void {
    router.patch(
        `/admin/tickets/${ticket.id}/approve`,
        {},
        { preserveScroll: true },
    );
}

function reject(ticket: TicketSummary): void {
    const rejectionReason = window.prompt('Motivo da rejeição');

    if (!rejectionReason) {
        return;
    }

    router.patch(
        `/admin/tickets/${ticket.id}/reject`,
        { rejection_reason: rejectionReason },
        { preserveScroll: true },
    );
}

function destroy(ticket: TicketSummary): void {
    if (!window.confirm('Excluir este ticket?')) {
        return;
    }

    router.delete(`/admin/tickets/${ticket.id}`, { preserveScroll: true });
}
</script>

<template>
    <Head title="Tickets" />

    <PageHeading
        title="Gestão de tickets"
        description="Visualize e gerencie todos os tickets da campanha."
    />

    <form
        class="mt-6 grid gap-3 md:grid-cols-[1fr_180px_220px_auto]"
        method="get"
    >
        <Input
            name="search"
            :default-value="props.filters.search"
            placeholder="Buscar por série, nome, e-mail ou CPF"
        />
        <select
            name="status"
            class="flex h-10 rounded-md border border-input bg-background px-3 py-2 text-sm"
        >
            <option value="">Todos os status</option>
            <option
                v-for="status in statuses"
                :key="status.value"
                :value="status.value"
                :selected="status.value === props.filters.status"
            >
                {{ status.label }}
            </option>
        </select>
        <select
            name="city_id"
            class="flex h-10 rounded-md border border-input bg-background px-3 py-2 text-sm"
        >
            <option value="">Todas as cidades</option>
            <option
                v-for="city in cities"
                :key="city.id"
                :value="city.id"
                :selected="String(city.id) === props.filters.city_id"
            >
                {{ city.name }} / {{ city.state }}
            </option>
        </select>
        <Button type="submit">Filtrar</Button>
    </form>

    <div class="mt-4 overflow-x-auto rounded-md border border-border">
        <table class="w-full min-w-[960px] text-sm">
            <thead class="bg-muted/50 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium">Série</th>
                    <th class="px-4 py-3 font-medium">Participante</th>
                    <th class="px-4 py-3 font-medium">Cidade</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium">Comprovante</th>
                    <th class="px-4 py-3 font-medium">Ações</th>
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
                        <p class="font-medium">{{ ticket.user?.name }}</p>
                        <p class="text-xs text-muted-foreground">
                            {{ ticket.user?.email }} · CPF
                            {{ ticket.user?.cpf }}
                        </p>
                    </td>
                    <td class="px-4 py-3">
                        {{ ticket.city.name }} / {{ ticket.city.state }}
                    </td>
                    <td class="px-4 py-3">
                        <StatusBadge
                            :status="ticket.status"
                            :label="ticket.status_label"
                        />
                    </td>
                    <td class="px-4 py-3">
                        <a
                            :href="ticket.proof_image_url"
                            target="_blank"
                            class="font-medium text-primary underline-offset-4 hover:underline"
                        >
                            Ver imagem
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2">
                            <Button as-child size="sm" variant="outline">
                                <Link
                                    :href="`/admin/tickets/${ticket.id}/edit`"
                                >
                                    Editar
                                </Link>
                            </Button>
                            <Button size="sm" @click="approve(ticket)">
                                Aprovar
                            </Button>
                            <Button
                                size="sm"
                                variant="outline"
                                @click="reject(ticket)"
                            >
                                Rejeitar
                            </Button>
                            <Button
                                size="sm"
                                variant="destructive"
                                @click="destroy(ticket)"
                            >
                                Excluir
                            </Button>
                        </div>
                    </td>
                </tr>
                <tr v-if="tickets.data.length === 0">
                    <td
                        colspan="6"
                        class="px-4 py-8 text-center text-muted-foreground"
                    >
                        Nenhum ticket encontrado.
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
