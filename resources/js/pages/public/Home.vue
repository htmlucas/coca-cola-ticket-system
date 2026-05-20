<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import CampaignPresentationSection from '@/components/public/landing/CampaignPresentationSection.vue';
import CtaBannerSection from '@/components/public/landing/CtaBannerSection.vue';
import HeroSection from '@/components/public/landing/HeroSection.vue';
import HowItWorksSection from '@/components/public/landing/HowItWorksSection.vue';
</script>

<template>
    <Head title="Campanha Coca-Cola" />

    <div class="flex flex-col">
        <HeroSection />
        <CampaignPresentationSection />
        <HowItWorksSection />
        <CtaBannerSection />
    </div>
</template>
