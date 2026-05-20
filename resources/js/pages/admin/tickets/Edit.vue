<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PageHeading from '@/components/shared/PageHeading.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import type { CityOption, StatusOption, TicketSummary } from '@/types';

const props = defineProps<{
    ticket: TicketSummary;
    statuses: StatusOption[];
    cities: CityOption[];
}>();

const form = useForm<{
    serial_number: string;
    city_id: number | undefined;
    status: string;
    rejection_reason: string;
    proof_image: File | null;
}>({
    serial_number: props.ticket.serial_number,
    city_id: props.ticket.city.id,
    status: props.ticket.status,
    rejection_reason: props.ticket.rejection_reason ?? '',
    proof_image: null,
});

function submit(): void {
    form.transform((data) => ({
        ...data,
        _method: 'PATCH',
    })).post(`/admin/tickets/${props.ticket.id}`, {
        forceFormData: true,
    });
}
</script>

<template>
    <Head title="Editar ticket" />

    <PageHeading
        title="Editar ticket"
        :description="`Ticket ${ticket.serial_number} de ${ticket.user?.name}`"
    />

    <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_360px]">
        <form
            class="space-y-6"
            enctype="multipart/form-data"
            @submit.prevent="submit"
        >
            <div class="grid gap-2">
                <Label for="serial_number">Número de série</Label>
                <Input
                    id="serial_number"
                    v-model="form.serial_number"
                    required
                    autocomplete="off"
                />
                <InputError :message="form.errors.serial_number" />
            </div>

            <div class="grid gap-2">
                <Label for="city_id">Cidade</Label>
                <select
                    id="city_id"
                    v-model="form.city_id"
                    class="flex h-10 rounded-md border border-input bg-background px-3 py-2 text-sm"
                    required
                >
                    <option
                        v-for="city in cities"
                        :key="city.id"
                        :value="city.id"
                    >
                        {{ city.name }} / {{ city.state }}
                    </option>
                </select>
                <InputError :message="form.errors.city_id" />
            </div>

            <div class="grid gap-2">
                <Label for="status">Status</Label>
                <select
                    id="status"
                    v-model="form.status"
                    class="flex h-10 rounded-md border border-input bg-background px-3 py-2 text-sm"
                    required
                >
                    <option
                        v-for="status in statuses"
                        :key="status.value"
                        :value="status.value"
                    >
                        {{ status.label }}
                    </option>
                </select>
                <InputError :message="form.errors.status" />
            </div>

            <div class="grid gap-2">
                <Label for="rejection_reason">Motivo da rejeição</Label>
                <textarea
                    id="rejection_reason"
                    v-model="form.rejection_reason"
                    rows="4"
                    class="rounded-md border border-input bg-background px-3 py-2 text-sm"
                />
                <InputError :message="form.errors.rejection_reason" />
            </div>

            <div class="grid gap-2">
                <Label for="proof_image">Substituir comprovante</Label>
                <Input
                    id="proof_image"
                    type="file"
                    accept="image/png,image/jpeg,image/webp"
                    @change="
                        form.proof_image =
                            ($event.target as HTMLInputElement).files?.[0] ??
                            null
                    "
                />
                <InputError :message="form.errors.proof_image" />
            </div>

            <div class="flex gap-3">
                <Button type="submit" :disabled="form.processing">
                    <Spinner v-if="form.processing" />
                    Salvar
                </Button>
                <Button as-child variant="outline">
                    <Link href="/admin/tickets">Voltar</Link>
                </Button>
            </div>
        </form>

        <aside class="space-y-4">
            <div class="rounded-md border border-border p-4">
                <p class="text-sm text-muted-foreground">Participante</p>
                <p class="mt-1 font-medium">{{ ticket.user?.name }}</p>
                <p class="text-sm text-muted-foreground">
                    {{ ticket.user?.email }}
                </p>
                <p class="text-sm text-muted-foreground">
                    CPF {{ ticket.user?.cpf }}
                </p>
            </div>

            <a :href="ticket.proof_image_url" target="_blank">
                <img
                    :src="ticket.proof_image_url"
                    alt="Comprovante do ticket"
                    class="w-full rounded-md border border-border object-cover"
                />
            </a>
        </aside>
    </div>
</template>
