import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { Auth, User } from '@/types';

export function useAuth() {
    const page = usePage<{ auth: Auth }>();

    const user = computed<User | null>(() => page.props.auth.user ?? null);
    const isAuthenticated = computed(() => user.value !== null);
    const isAdmin = computed(() => page.props.auth.isAdmin);

    return {
        user,
        isAuthenticated,
        isAdmin,
    };
}
