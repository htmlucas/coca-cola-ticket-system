import { createInertiaApp } from '@inertiajs/vue3';
import { initializeTheme } from '@/composables/useAppearance';
import { resolveLayout } from '@/layouts/resolveLayout';
import { initializeFlashToast } from '@/lib/flashToast';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: (name) => resolveLayout(name),
    progress: {
        color: '#4B5563',
    },
});

initializeTheme();

initializeFlashToast();
