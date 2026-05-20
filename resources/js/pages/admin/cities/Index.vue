<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PageHeading from '@/components/shared/PageHeading.vue';

type City = {
    id: number;
    name: string;
    users_count: number;
    tickets_count: number;
};

type StateWithCities = {
    id: number;
    name: string;
    abbreviation: string;
    cities_count: number;
    cities: City[];
};

defineProps<{
    states: StateWithCities[];
}>();
</script>

<template>
    <Head title="Cidades" />

    <PageHeading
        title="Gestão de cidades"
        description="Consulte os estados e cidades participantes da campanha."
    />

    <div class="mt-6 grid gap-4 md:grid-cols-2">
        <section
            v-for="state in states"
            :key="state.id"
            class="rounded-md border border-border p-4"
        >
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="font-semibold">
                        {{ state.name }} / {{ state.abbreviation }}
                    </h2>
                    <p class="text-sm text-muted-foreground">
                        {{ state.cities_count }} cidades cadastradas
                    </p>
                </div>
            </div>

            <div class="mt-4 overflow-hidden rounded-md border border-border">
                <table class="w-full text-sm">
                    <thead class="bg-muted/50 text-left">
                        <tr>
                            <th class="px-3 py-2 font-medium">Cidade</th>
                            <th class="px-3 py-2 font-medium">Usuários</th>
                            <th class="px-3 py-2 font-medium">Tickets</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="city in state.cities"
                            :key="city.id"
                            class="border-t border-border"
                        >
                            <td class="px-3 py-2">{{ city.name }}</td>
                            <td class="px-3 py-2">{{ city.users_count }}</td>
                            <td class="px-3 py-2">{{ city.tickets_count }}</td>
                        </tr>
                        <tr v-if="state.cities.length === 0">
                            <td
                                colspan="3"
                                class="px-3 py-5 text-center text-muted-foreground"
                            >
                                Nenhuma cidade cadastrada para este estado.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</template>
