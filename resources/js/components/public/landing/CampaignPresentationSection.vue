<script setup lang="ts">
import FeatureCard from '@/components/public/landing/FeatureCard.vue';
import SectionContainer from '@/components/public/landing/SectionContainer.vue';
import SectionHeading from '@/components/public/landing/SectionHeading.vue';
import { campaignLanding } from '@/config/campaign';

const { presentation, features } = campaignLanding;
</script>

<template>
    <SectionContainer id="campanha" class="bg-coke-cream py-16 sm:py-20">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-start lg:gap-16">
            <div class="space-y-8">
                <SectionHeading
                    :eyebrow="presentation.eyebrow"
                    :title="presentation.title"
                    :description="presentation.description"
                />

                <dl class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
                    <div
                        v-for="item in presentation.highlights"
                        :key="item.label"
                        class="rounded-xl border border-border/60 bg-background p-4 shadow-sm"
                    >
                        <dt
                            class="text-xs font-medium tracking-wide text-muted-foreground uppercase"
                        >
                            {{ item.label }}
                        </dt>
                        <dd class="mt-1 text-sm font-semibold sm:text-base">
                            {{ item.value }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <FeatureCard
                    v-for="feature in features"
                    :key="feature.title"
                    v-bind="feature"
                />
            </div>
        </div>
    </SectionContainer>
</template>
