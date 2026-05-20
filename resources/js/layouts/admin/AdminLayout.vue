<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLogo from '@/components/AppLogo.vue';
import { Button } from '@/components/ui/button';
import { Toaster } from '@/components/ui/sonner';
import { adminNav } from '@/config/navigation';
import { cn } from '@/lib/utils';

const page = usePage();
const user = computed(() => page.props.auth.user);
const currentUrl = computed(() => page.url);

function isActive(href: string): boolean {
    return currentUrl.value === href || currentUrl.value.startsWith(`${href}/`);
}

function logout(): void {
    router.post('/logout');
}
</script>

<template>
    <div class="flex min-h-svh bg-background">
        <aside
            class="hidden w-64 shrink-0 border-r border-border bg-muted/30 md:flex md:flex-col"
        >
            <div class="flex h-16 items-center border-b border-border px-4">
                <Link href="/admin/dashboard" class="flex items-center gap-2">
                    <AppLogo />
                </Link>
            </div>

            <nav class="flex flex-1 flex-col gap-1 p-3">
                <Link
                    v-for="item in adminNav"
                    :key="item.href"
                    :href="item.href"
                    :class="
                        cn(
                            'rounded-md px-3 py-2 text-sm font-medium transition-colors',
                            isActive(item.href)
                                ? 'bg-background text-foreground shadow-sm'
                                : 'text-muted-foreground hover:bg-background/60 hover:text-foreground',
                        )
                    "
                >
                    {{ item.title }}
                </Link>
            </nav>

            <div class="border-t border-border p-3">
                <p
                    v-if="user"
                    class="mb-2 truncate text-xs text-muted-foreground"
                >
                    {{ user.name }}
                </p>
                <Button
                    variant="outline"
                    size="sm"
                    class="w-full"
                    @click="logout"
                >
                    Sair
                </Button>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header
                class="flex h-16 items-center justify-between border-b border-border px-4 md:px-6"
            >
                <p class="text-sm font-medium text-muted-foreground">
                    Administração
                </p>
                <Button as-child variant="ghost" size="sm" class="md:hidden">
                    <Link href="/">Voltar ao site</Link>
                </Button>
            </header>

            <main class="flex-1 p-4 md:p-6">
                <slot />
            </main>
        </div>

        <Toaster />
    </div>
</template>
