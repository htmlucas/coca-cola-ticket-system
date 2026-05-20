<script setup lang="ts">
import LandingCta from '@/components/public/landing/LandingCta.vue';
import SectionContainer from '@/components/public/landing/SectionContainer.vue';
import { campaignLanding } from '@/config/campaign';
import { login, register } from '@/routes';

const { cta } = campaignLanding;
</script>

<template>
    <SectionContainer class="pb-16 sm:pb-20">
        <div
            class="relative overflow-hidden rounded-3xl bg-linear-to-r from-coke-red to-coke-red-dark px-6 py-10 text-center text-white sm:px-10 sm:py-14"
        >
            <div
                class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent_50%)]"
                aria-hidden="true"
            />

            <div class="relative mx-auto max-w-2xl space-y-6">
                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">
                    {{ cta.title }}
                </h2>
                <p class="text-base leading-relaxed text-white/85 sm:text-lg">
                    {{ cta.description }}
                </p>
                <div
                    class="flex flex-col items-center justify-center gap-3 sm:flex-row"
                >
                    <LandingCta
                        :href="register().url"
                        :label="cta.primaryCta"
                        variant="inverse"
                    />
                    <LandingCta
                        :href="login().url"
                        :label="cta.secondaryCta"
                        variant="secondary"
                        class="border-white/40 bg-transparent hover:bg-white/10"
                    />
                </div>
            </div>
        </div>
    </SectionContainer>
</template>
