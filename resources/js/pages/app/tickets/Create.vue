<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PageHeading from '@/components/shared/PageHeading.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';

defineProps<{
    city: {
        id: number;
        name: string;
        state: {
            abbreviation: string;
        };
    } | null;
}>();

const form = useForm<{
    serial_number: string;
    proof_image: File | null;
    city_id: string;
}>({
    serial_number: '',
    proof_image: null,
    city_id: '',
});

function submit(): void {
    form.post('/app/tickets', {
        forceFormData: true,
    });
}
</script>

<template>
    <Head title="Registrar ticket" />

    <PageHeading
        title="Registrar ticket"
        description="Envie os dados do seu ticket para participar da promoção."
    />

    <div
        v-if="!city"
        class="mt-6 rounded-md border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800"
    >
        Complete sua cidade em configurações de perfil antes de registrar
        tickets.
        <Link href="/settings/profile" class="font-medium underline">
            Atualizar perfil
        </Link>
    </div>

    <form
        v-else
        class="mt-6 max-w-2xl space-y-6"
        enctype="multipart/form-data"
        @submit.prevent="submit"
    >
        <div class="rounded-md border border-border bg-card p-4 text-sm">
            Cidade participante:
            <strong>{{ city.name }} / {{ city.state.abbreviation }}</strong>
        </div>

        <div class="grid gap-2">
            <Label for="serial_number">Número de série do ticket</Label>
            <Input
                id="serial_number"
                v-model="form.serial_number"
                name="serial_number"
                required
                autocomplete="off"
                placeholder="Ex: CC-1234-ABCD"
            />
            <InputError :message="form.errors.serial_number" />
        </div>

        <div class="grid gap-2">
            <Label for="proof_image">Foto da lata Coca-Cola</Label>
            <Input
                id="proof_image"
                type="file"
                name="proof_image"
                accept="image/png,image/jpeg,image/webp"
                required
                @change="
                    form.proof_image =
                        ($event.target as HTMLInputElement).files?.[0] ?? null
                "
            />
            <InputError :message="form.errors.proof_image" />
            <InputError :message="form.errors.city_id" />
        </div>

        <div class="flex items-center gap-3">
            <Button type="submit" :disabled="form.processing">
                <Spinner v-if="form.processing" />
                Registrar ticket
            </Button>
            <Button as-child variant="outline">
                <Link href="/app/tickets">Voltar</Link>
            </Button>
        </div>
    </form>
</template>
