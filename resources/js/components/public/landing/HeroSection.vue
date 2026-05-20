<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Sparkles } from 'lucide-vue-next';
import LandingCta from '@/components/public/landing/LandingCta.vue';
import { campaignLanding } from '@/config/campaign';
import { register } from '@/routes';

const { hero } = campaignLanding;
</script>

<template>
    <section
        class="relative overflow-hidden bg-linear-to-br from-coke-red via-coke-red to-coke-red-dark text-white"
    >
        <div
            class="pointer-events-none absolute inset-0 opacity-30"
            aria-hidden="true"
        >
            <div
                class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-white/20 blur-3xl"
            />
            <div
                class="absolute -bottom-32 -left-16 h-80 w-80 rounded-full bg-black/20 blur-3xl"
            />
            <div
                class="absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgba(255,255,255,0.12)_1px,transparent_0)] bg-size-[24px_24px]"
            />
        </div>

        <div
            class="relative mx-auto flex w-full max-w-6xl flex-col gap-10 px-4 py-14 sm:py-16 md:px-6 md:py-20 lg:flex-row lg:items-center lg:gap-16 lg:px-8 lg:py-24"
        >
            <div class="flex flex-1 flex-col gap-6 text-center lg:text-left">
                <div
                    class="inline-flex items-center justify-center gap-2 self-center rounded-full border border-white/25 bg-white/10 px-3 py-1 text-xs font-medium backdrop-blur-sm sm:text-sm lg:self-start"
                >
                    <Sparkles class="h-3.5 w-3.5" aria-hidden="true" />
                    {{ hero.eyebrow }}
                </div>

                <h1
                    class="text-4xl font-extrabold tracking-tight text-balance sm:text-5xl lg:text-6xl"
                >
                    {{ hero.title }}
                    <span class="block text-white/90">{{
                        hero.titleHighlight
                    }}</span>
                </h1>

                <p
                    class="mx-auto max-w-xl text-base leading-relaxed text-white/85 sm:text-lg lg:mx-0"
                >
                    {{ hero.description }}
                </p>

                <div
                    class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:justify-center lg:justify-start"
                >
                    <LandingCta
                        :href="register().url"
                        :label="hero.primaryCta"
                        variant="inverse"
                    />
                    <LandingCta
                        href="#como-funciona"
                        :label="hero.secondaryCta"
                        variant="secondary"
                        class="border-white/40 bg-transparent hover:bg-white/10"
                    />
                </div>
            </div>

            <div class="flex flex-1 justify-center lg:justify-end">
                <div class="relative w-full max-w-sm sm:max-w-md lg:max-w-lg">
                    <div
                        class="absolute -inset-4 rounded-[2rem] bg-white/10 blur-xl"
                        aria-hidden="true"
                    />
                    <div
                        class="relative overflow-hidden rounded-3xl border border-white/20 bg-white/10 p-6 shadow-2xl backdrop-blur-md sm:p-8"
                    >
                        <div
                            class="mb-6 flex items-center justify-between gap-4"
                        >
                            <div
                                class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-2xl font-black text-coke-red shadow-lg"
                            >
                                CC
                            </div>
                            <span
                                class="rounded-full bg-white/20 px-3 py-1 text-xs font-semibold"
                            >
                                Promoção 2026
                            </span>
                        </div>
                        <p class="text-lg font-semibold sm:text-xl">
                            Sua participação começa aqui
                        </p>
                        <p class="mt-2 text-sm leading-relaxed text-white/80">
                            Registre tickets, acompanhe seu histórico e descubra
                            prêmios em um só lugar.
                        </p>
                        <ul class="mt-6 space-y-3 text-sm">
                            <li class="flex items-center gap-2">
                                <span
                                    class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/20 text-xs font-bold"
                                    >✓</span
                                >
                                Cadastro em menos de 1 minuto
                            </li>
                            <li class="flex items-center gap-2">
                                <span
                                    class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/20 text-xs font-bold"
                                    >✓</span
                                >
                                Histórico completo de tickets
                            </li>
                            <li class="flex items-center gap-2">
                                <span
                                    class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/20 text-xs font-bold"
                                    >✓</span
                                >
                                Válido em todo o Brasil
                            </li>
                        </ul>
                        <Link
                            href="/campanha"
                            class="mt-6 inline-flex text-sm font-semibold underline-offset-4 hover:underline"
                        >
                            Ver regulamento completo →
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
