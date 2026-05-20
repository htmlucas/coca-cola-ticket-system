<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

defineProps<{
    id: string;
    name: string;
    label: string;
    type?: string;
    error?: string;
    autocomplete?: string;
    inputmode?: string;
    placeholder?: string;
    required?: boolean;
    autofocus?: boolean;
    tabindex?: number;
}>();
</script>

<template>
    <div class="grid gap-2">
        <Label :for="id">{{ label }}</Label>
        <Input
            :id="id"
            :name="name"
            :type="type ?? 'text'"
            :required="required"
            :autofocus="autofocus"
            :tabindex="tabindex"
            :autocomplete="autocomplete"
            :inputmode="inputmode"
            :placeholder="placeholder"
        />
        <InputError :message="error" />
    </div>
</template>
