<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Label } from '@/components/ui/label';

defineProps<{
    id: string;
    name: string;
    label: string;
    error?: string;
    autocomplete?: string;
    placeholder?: string;
    required?: boolean;
    tabindex?: number;
}>();
</script>

<template>
    <div class="grid gap-2">
        <Label :for="id">{{ label }}</Label>
        <PasswordInput
            :id="id"
            :name="name"
            :required="required"
            :tabindex="tabindex"
            :autocomplete="autocomplete"
            :placeholder="placeholder"
        />
        <InputError :message="error" />
    </div>
</template>
