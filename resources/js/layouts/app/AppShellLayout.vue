<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLogo from '@/components/AppLogo.vue';
import AuthUserMenu from '@/components/auth/AuthUserMenu.vue';
import { Button } from '@/components/ui/button';
import { Toaster } from '@/components/ui/sonner';
import { appNav } from '@/config/navigation';
import { cn } from '@/lib/utils';

const page = usePage();
const currentUrl = computed(() => page.url);

function isActive(href: string): boolean {
    return currentUrl.value === href || currentUrl.value.startsWith(`${href}/`);
}

function logout(): void {
    router.post('/logout');
}
</script>

<template>
    <div class="flex min-h-svh flex-col bg-background">
        <header class="border-b border-border">
            <div
                class="mx-auto flex h-16 w-full max-w-6xl items-center justify-between gap-4 px-4 md:px-6"
            >
                <Link href="/app/dashboard" class="flex items-center gap-2">
                    <AppLogo />
                </Link>

                <nav class="hidden items-center gap-1 md:flex">
                    <Link
                        v-for="item in appNav"
                        :key="item.href"
                        :href="item.href"
                        :class="
                            cn(
                                'rounded-md px-3 py-2 text-sm font-medium transition-colors',
                                isActive(item.href)
                                    ? 'bg-muted text-foreground'
                                    : 'text-muted-foreground hover:bg-muted/50 hover:text-foreground',
                            )
                        "
                    >
                        {{ item.title }}
                    </Link>
                </nav>

                <div class="flex items-center gap-2">
                    <AuthUserMenu />
                    <Button variant="outline" size="sm" @click="logout">
                        Sair
                    </Button>
                </div>
            </div>
        </header>

        <main class="mx-auto w-full max-w-6xl flex-1 px-4 py-8 md:px-6">
            <slot />
        </main>

        <Toaster />
    </div>
</template>
