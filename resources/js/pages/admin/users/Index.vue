<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import PageHeading from '@/components/shared/PageHeading.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import type { Paginated } from '@/types';

type Participant = {
    id: number;
    name: string;
    email: string;
    cpf: string | null;
    is_admin: boolean;
    tickets_count: number;
    city: {
        name: string;
        state: string;
    } | null;
    created_at: string | null;
};

const props = defineProps<{
    users: Paginated<Participant>;
    filters: {
        search: string;
    };
}>();

function resendEmail(user: Participant): void {
    router.post(
        `/admin/users/${user.id}/resend-email`,
        {},
        { preserveScroll: true },
    );
}
</script>

<template>
    <Head title="Usuários" />

    <PageHeading
        title="Gestão de usuários"
        description="Gerencie participantes e reenvio de e-mails."
    />

    <form class="mt-6 flex gap-3" method="get">
        <Input
            name="search"
            :default-value="props.filters.search"
            placeholder="Buscar por nome, e-mail ou CPF"
        />
        <Button type="submit">Buscar</Button>
    </form>

    <div class="mt-4 overflow-x-auto rounded-md border border-border">
        <table class="w-full min-w-[820px] text-sm">
            <thead class="bg-muted/50 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium">Participante</th>
                    <th class="px-4 py-3 font-medium">CPF</th>
                    <th class="px-4 py-3 font-medium">Cidade</th>
                    <th class="px-4 py-3 font-medium">Tickets</th>
                    <th class="px-4 py-3 font-medium">Cadastro</th>
                    <th class="px-4 py-3 font-medium">Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="user in users.data"
                    :key="user.id"
                    class="border-t border-border"
                >
                    <td class="px-4 py-3">
                        <p class="font-medium">{{ user.name }}</p>
                        <p class="text-xs text-muted-foreground">
                            {{ user.email }}
                        </p>
                    </td>
                    <td class="px-4 py-3">{{ user.cpf ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <template v-if="user.city">
                            {{ user.city.name }} / {{ user.city.state }}
                        </template>
                        <span v-else>-</span>
                    </td>
                    <td class="px-4 py-3">{{ user.tickets_count }}</td>
                    <td class="px-4 py-3">{{ user.created_at }}</td>
                    <td class="px-4 py-3">
                        <Button
                            size="sm"
                            variant="outline"
                            @click="resendEmail(user)"
                        >
                            Reenviar e-mail
                        </Button>
                    </td>
                </tr>
                <tr v-if="users.data.length === 0">
                    <td
                        colspan="6"
                        class="px-4 py-8 text-center text-muted-foreground"
                    >
                        Nenhum usuário encontrado.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <nav
        v-if="users.links.length > 3"
        class="mt-4 flex flex-wrap gap-2"
        aria-label="Paginação"
    >
        <Link
            v-for="link in users.links"
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
