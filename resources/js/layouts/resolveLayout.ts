import type { Component } from 'vue';
import AdminLayout from '@/layouts/admin/AdminLayout.vue';
import AppShellLayout from '@/layouts/app/AppShellLayout.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import GuestLayout from '@/layouts/public/GuestLayout.vue';
import MarketingLayout from '@/layouts/public/MarketingLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

export function resolveLayout(name: string): Component | Component[] | null {
    if (name.startsWith('public/') && name.includes('/auth/')) {
        return GuestLayout;
    }

    if (name.startsWith('public/')) {
        return MarketingLayout;
    }

    if (name.startsWith('app/')) {
        return AppShellLayout;
    }

    if (name.startsWith('admin/')) {
        return AdminLayout;
    }

    if (name.startsWith('settings/') || name.startsWith('teams/')) {
        return [AppLayout, SettingsLayout];
    }

    return null;
}
