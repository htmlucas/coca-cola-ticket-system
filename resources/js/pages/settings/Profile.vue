<script setup lang="ts">
import { Form, Head, usePage } from '@inertiajs/vue3';
import { computed, ref, watchEffect } from 'vue';
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import DeleteUser from '@/components/DeleteUser.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import CpfInput from '@/components/shared/CpfInput.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { formatCpf } from '@/lib/cpf';
import { edit } from '@/routes/profile';
import type { StateOption } from '@/types';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Profile settings',
                href: edit(),
            },
        ],
    },
});

const page = usePage();
const user = computed(() => page.props.auth.user);
const cpf = ref('');

watchEffect(() => {
    cpf.value = formatCpf(user.value?.cpf ?? '');
});

defineProps<{
    states: StateOption[];
}>();
</script>

<template>
    <Head title="Profile settings" />

    <h1 class="sr-only">Profile settings</h1>

    <div v-if="user" class="flex flex-col space-y-6">
        <Heading
            variant="small"
            title="Profile information"
            description="Update your name and email address"
        />

        <Form
            v-bind="ProfileController.update.form()"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input
                    id="name"
                    class="mt-1 block w-full"
                    name="name"
                    :default-value="user.name"
                    required
                    autocomplete="name"
                    placeholder="Full name"
                />
                <InputError class="mt-2" :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="email">Email address</Label>
                <Input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    name="email"
                    :default-value="user.email"
                    required
                    autocomplete="username"
                    placeholder="Email address"
                />
                <InputError class="mt-2" :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <Label for="cpf">CPF</Label>
                <CpfInput
                    id="cpf"
                    class="mt-1 block w-full"
                    v-model="cpf"
                    name="cpf"
                    required
                />
                <InputError class="mt-2" :message="errors.cpf" />
            </div>

            <div class="grid gap-2">
                <Label for="city_id">Cidade</Label>
                <select
                    id="city_id"
                    name="city_id"
                    required
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                >
                    <option value="">Selecione sua cidade</option>
                    <optgroup
                        v-for="state in states"
                        :key="state.id"
                        :label="`${state.name} (${state.abbreviation})`"
                    >
                        <option
                            v-for="city in state.cities"
                            :key="city.id"
                            :value="city.id"
                            :selected="city.id === user.city_id"
                        >
                            {{ city.name }}
                        </option>
                    </optgroup>
                </select>
                <InputError class="mt-2" :message="errors.city_id" />
            </div>

            <div class="flex items-center gap-4">
                <Button :disabled="processing" data-test="update-profile-button"
                    >Save</Button
                >
            </div>
        </Form>
    </div>

    <DeleteUser />
</template>
