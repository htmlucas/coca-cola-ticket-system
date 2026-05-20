export type NavItem = {
    title: string;
    href: string;
};

export const publicNav: NavItem[] = [
    { title: 'Início', href: '/' },
    { title: 'Campanha', href: '/#campanha' },
    { title: 'Como funciona', href: '/#como-funciona' },
];

export const appNav: NavItem[] = [
    { title: 'Dashboard', href: '/app/dashboard' },
    { title: 'Meus tickets', href: '/app/tickets' },
    { title: 'Registrar ticket', href: '/app/tickets/register' },
];

export const adminNav: NavItem[] = [
    { title: 'Dashboard', href: '/admin/dashboard' },
    { title: 'Usuários', href: '/admin/users' },
    { title: 'Tickets', href: '/admin/tickets' },
    { title: 'Cidades', href: '/admin/cities' },
];
