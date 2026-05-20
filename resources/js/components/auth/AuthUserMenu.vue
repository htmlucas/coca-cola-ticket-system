<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { useAuth } from '@/composables/useAuth';
import { cn } from '@/lib/utils';
import { login, register } from '@/routes';
import { dashboard as adminDashboard } from '@/routes/admin';
import { dashboard as appDashboard } from '@/routes/app';

const props = defineProps<{
    inverted?: boolean;
}>();

const { user, isAuthenticated, isAdmin } = useAuth();

const ghostClass = cn(
    props.inverted && 'text-white hover:bg-white/10 hover:text-white',
);
const outlineClass = cn(
    props.inverted &&
        'border-white/40 bg-transparent text-white hover:bg-white/10 hover:text-white',
);
const primaryClass = cn(
    props.inverted && 'bg-white text-coke-red hover:bg-white/90',
);
const nameClass = cn(
    props.inverted ? 'text-white/80' : 'text-muted-foreground',
);
</script>

<template>
    <template v-if="isAuthenticated && user">
        <Badge
            v-if="isAdmin"
            variant="secondary"
            class="hidden sm:inline-flex"
            :class="inverted && 'border-white/30 bg-white/15 text-white'"
        >
            Admin
        </Badge>
        <span class="hidden text-sm md:inline" :class="nameClass">
            {{ user.name }}
        </span>
        <Button as-child variant="outline" size="sm" :class="outlineClass">
            <Link :href="isAdmin ? adminDashboard() : appDashboard()">
                {{ isAdmin ? 'Painel admin' : 'Minha conta' }}
            </Link>
        </Button>
    </template>
    <template v-else>
        <Button as-child variant="ghost" size="sm" :class="ghostClass">
            <Link :href="login()">Entrar</Link>
        </Button>
        <Button as-child size="sm" :class="primaryClass">
            <Link :href="register()">Cadastrar</Link>
        </Button>
    </template>
</template>
