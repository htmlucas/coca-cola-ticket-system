<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { formatCpf, onlyCpfDigits } from '@/lib/cpf';

const props = defineProps<{
    id: string;
    name: string;
    modelValue: string;
    required?: boolean;
    tabindex?: number;
    class?: string;
}>();

const emit = defineEmits<{
    'update:modelValue': [value: string];
}>();

const navigationKeys = new Set([
    'Backspace',
    'Delete',
    'ArrowLeft',
    'ArrowRight',
    'ArrowUp',
    'ArrowDown',
    'Home',
    'End',
    'Tab',
]);

function syncInput(input: HTMLInputElement, value: string): void {
    const formatted = formatCpf(value);

    input.value = formatted;
    emit('update:modelValue', formatted);
}

function handleInput(event: Event): void {
    syncInput(
        event.target as HTMLInputElement,
        (event.target as HTMLInputElement).value,
    );
}

function handlePaste(event: ClipboardEvent): void {
    event.preventDefault();

    const input = event.target as HTMLInputElement;
    const selectionStart = input.selectionStart ?? input.value.length;
    const selectionEnd = input.selectionEnd ?? input.value.length;
    const prefixDigits = onlyCpfDigits(input.value.slice(0, selectionStart));
    const suffixDigits = onlyCpfDigits(input.value.slice(selectionEnd));
    const pastedDigits = onlyCpfDigits(
        event.clipboardData?.getData('text') ?? '',
    );
    const availableDigits = 11 - prefixDigits.length - suffixDigits.length;
    const nextDigits = `${prefixDigits}${pastedDigits.slice(0, Math.max(availableDigits, 0))}${suffixDigits}`;

    syncInput(input, nextDigits);
}

function handleKeydown(event: KeyboardEvent): void {
    if (
        event.ctrlKey ||
        event.metaKey ||
        event.altKey ||
        navigationKeys.has(event.key)
    ) {
        return;
    }

    if (!/^\d$/.test(event.key)) {
        event.preventDefault();

        return;
    }

    const input = event.target as HTMLInputElement;
    const digits = onlyCpfDigits(input.value);
    const hasSelection =
        (input.selectionEnd ?? 0) > (input.selectionStart ?? 0);

    if (digits.length >= 11 && !hasSelection) {
        event.preventDefault();
    }
}
</script>

<template>
    <Input
        :id="props.id"
        :name="props.name"
        :model-value="props.modelValue"
        :required="props.required"
        :tabindex="props.tabindex"
        :class="props.class"
        inputmode="numeric"
        autocomplete="off"
        maxlength="14"
        placeholder="000.000.000-00"
        @input="handleInput"
        @paste="handlePaste"
        @keydown="handleKeydown"
    />
</template>
