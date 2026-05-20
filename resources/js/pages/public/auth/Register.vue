<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import AuthPasswordField from '@/components/auth/AuthPasswordField.vue';
import AuthTextField from '@/components/auth/AuthTextField.vue';
import InputError from '@/components/InputError.vue';
import CpfInput from '@/components/shared/CpfInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { store } from '@/routes/register';
import type { StateOption } from '@/types';

defineOptions({
    layout: {
        title: 'Criar conta',
        description: 'Cadastre-se com seu e-mail para participar da campanha',
    },
});

defineProps<{
    status?: string;
    states: StateOption[];
}>();

const cpf = ref('');
</script>

<template>
    <Head title="Cadastro" />

    <div
        v-if="status"
        class="mb-4 text-center text-sm font-medium text-green-600"
    >
        {{ status }}
    </div>

    <Form
        v-bind="store.form()"
        :reset-on-success="['password', 'password_confirmation']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-6"
    >
        <div class="grid gap-6">
            <AuthTextField
                id="name"
                name="name"
                label="Nome completo"
                autocomplete="name"
                placeholder="Seu nome"
                required
                autofocus
                :tabindex="1"
                :error="errors.name"
            />

            <AuthTextField
                id="email"
                name="email"
                label="E-mail"
                type="email"
                autocomplete="email"
                placeholder="email@exemplo.com"
                required
                :tabindex="2"
                :error="errors.email"
            />

            <div class="grid gap-2">
                <Label for="cpf">CPF</Label>
                <CpfInput
                    id="cpf"
                    v-model="cpf"
                    name="cpf"
                    required
                    :tabindex="3"
                />
                <InputError :message="errors.cpf" />
            </div>

            <div class="grid gap-2">
                <Label for="city_id">Cidade</Label>
                <select
                    id="city_id"
                    name="city_id"
                    required
                    :tabindex="4"
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
                        >
                            {{ city.name }}
                        </option>
                    </optgroup>
                </select>
                <InputError :message="errors.city_id" />
            </div>

            <AuthPasswordField
                id="password"
                name="password"
                label="Senha"
                autocomplete="new-password"
                placeholder="Senha"
                required
                :tabindex="5"
                :error="errors.password"
            />

            <AuthPasswordField
                id="password_confirmation"
                name="password_confirmation"
                label="Confirmar senha"
                autocomplete="new-password"
                placeholder="Confirme sua senha"
                required
                :tabindex="6"
                :error="errors.password_confirmation"
            />

            <Button
                type="submit"
                class="mt-2 w-full"
                :tabindex="7"
                :disabled="processing"
                data-test="register-button"
            >
                <Spinner v-if="processing" />
                Criar conta
            </Button>
        </div>

        <p class="text-center text-sm text-muted-foreground">
            Já tem uma conta?
            <TextLink :href="login()">Entrar</TextLink>
        </p>
    </Form>
</template>
