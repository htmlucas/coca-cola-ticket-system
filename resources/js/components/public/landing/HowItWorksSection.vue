<script setup lang="ts">
import SectionContainer from '@/components/public/landing/SectionContainer.vue';
import SectionHeading from '@/components/public/landing/SectionHeading.vue';
import { campaignLanding } from '@/config/campaign';

const { steps } = campaignLanding;
</script>

<template>
    <SectionContainer id="como-funciona" class="py-16 sm:py-20">
        <SectionHeading
            eyebrow="Passo a passo"
            title="Como participar"
            description="Em quatro etapas simples você entra na promoção e acompanha tudo pela plataforma."
            align="center"
            class="mb-12"
        />

        <ol class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <li
                v-for="item in steps"
                :key="item.step"
                class="relative flex flex-col gap-4 rounded-2xl border border-border bg-card p-5 shadow-sm sm:p-6"
            >
                <span
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-coke-red text-sm font-bold text-white"
                >
                    {{ item.step }}
                </span>
                <div class="space-y-2">
                    <h3 class="text-lg font-semibold">
                        {{ item.title }}
                    </h3>
                    <p class="text-sm leading-relaxed text-muted-foreground">
                        {{ item.description }}
                    </p>
                </div>
            </li>
        </ol>
    </SectionContainer>
</template>
