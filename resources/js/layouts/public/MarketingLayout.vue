<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Menu, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import AppLogo from '@/components/AppLogo.vue';
import AuthUserMenu from '@/components/auth/AuthUserMenu.vue';
import { Button } from '@/components/ui/button';
import { Toaster } from '@/components/ui/sonner';
import { publicNav } from '@/config/navigation';
import { cn } from '@/lib/utils';

const page = usePage();
const mobileMenuOpen = ref(false);

const isHome = computed(() => page.url === '/' || page.url === '');
</script>

<template>
    <div class="flex min-h-svh flex-col bg-background">
        <header
            :class="
                cn(
                    'sticky top-0 z-50 border-b transition-colors',
                    isHome
                        ? 'border-white/10 bg-coke-red/95 text-white backdrop-blur-md'
                        : 'border-border bg-background/95 backdrop-blur-md',
                )
            "
        >
            <div
                class="mx-auto flex h-16 w-full max-w-6xl items-center justify-between gap-4 px-4 md:px-6 lg:px-8"
            >
                <Link href="/" class="flex items-center gap-2">
                    <AppLogo />
                </Link>

                <nav class="hidden items-center gap-6 md:flex">
                    <Link
                        v-for="item in publicNav"
                        :key="item.href"
                        :href="item.href"
                        :class="
                            cn(
                                'text-sm font-medium transition-colors',
                                isHome
                                    ? 'text-white/80 hover:text-white'
                                    : 'text-muted-foreground hover:text-foreground',
                            )
                        "
                    >
                        {{ item.title }}
                    </Link>
                </nav>

                <div class="flex items-center gap-2">
                    <AuthUserMenu :inverted="isHome" />
                    <Button
                        variant="ghost"
                        size="icon"
                        class="md:hidden"
                        :class="
                            isHome &&
                            'text-white hover:bg-white/10 hover:text-white'
                        "
                        aria-label="Abrir menu"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                    >
                        <Menu v-if="!mobileMenuOpen" class="h-5 w-5" />
                        <X v-else class="h-5 w-5" />
                    </Button>
                </div>
            </div>

            <nav
                v-show="mobileMenuOpen"
                class="border-t px-4 py-4 md:hidden"
                :class="isHome ? 'border-white/10' : 'border-border'"
            >
                <ul class="flex flex-col gap-3">
                    <li v-for="item in publicNav" :key="item.href">
                        <Link
                            :href="item.href"
                            class="block rounded-lg px-3 py-2 text-sm font-medium"
                            :class="
                                isHome
                                    ? 'text-white/90 hover:bg-white/10'
                                    : 'text-foreground hover:bg-muted'
                            "
                            @click="mobileMenuOpen = false"
                        >
                            {{ item.title }}
                        </Link>
                    </li>
                </ul>
            </nav>
        </header>

        <main class="flex-1">
            <slot />
        </main>

        <footer
            class="border-t py-8"
            :class="isHome ? 'border-border bg-coke-cream' : 'border-border'"
        >
            <div
                class="mx-auto flex w-full max-w-6xl flex-col items-center justify-between gap-4 px-4 text-center md:flex-row md:px-6 md:text-left lg:px-8"
            >
                <p class="text-sm text-muted-foreground">
                    © {{ new Date().getFullYear() }} Coca-Cola Campaign
                    Platform. Todos os direitos reservados.
                </p>
                <div class="flex flex-wrap justify-center gap-4 text-sm">
                    <Link
                        href="/campanha"
                        class="text-muted-foreground hover:text-foreground"
                    >
                        Regulamento
                    </Link>
                    <Link
                        href="/login"
                        class="text-muted-foreground hover:text-foreground"
                    >
                        Entrar
                    </Link>
                </div>
            </div>
        </footer>

        <Toaster />
    </div>
</template>
