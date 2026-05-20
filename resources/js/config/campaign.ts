export type CampaignStep = {
    step: number;
    title: string;
    description: string;
};

export type CampaignFeature = {
    title: string;
    description: string;
    icon: 'ticket' | 'gift' | 'map' | 'shield';
};

export const campaignLanding = {
    hero: {
        eyebrow: 'Promoção oficial',
        title: 'Sinta o sabor da',
        titleHighlight: 'vitória',
        description:
            'Compre produtos participantes, registre seus tickets e concorra a prêmios exclusivos em todo o Brasil.',
        primaryCta: 'Participar agora',
        secondaryCta: 'Como funciona',
    },
    presentation: {
        eyebrow: 'A campanha',
        title: 'Uma promoção feita para você',
        description:
            'A Coca-Cola preparou uma experiência simples e transparente: compre, registre e acompanhe sua participação em tempo real na plataforma.',
        highlights: [
            {
                label: 'Período',
                value: '01/06 – 31/08/2026',
            },
            {
                label: 'Participantes',
                value: 'Todo o Brasil',
            },
            {
                label: 'Registros',
                value: 'Ilimitados por usuário',
            },
        ] as const,
    },
    features: [
        {
            title: 'Registro rápido',
            description:
                'Cadastre seus tickets em poucos passos com validação instantânea.',
            icon: 'ticket',
        },
        {
            title: 'Prêmios exclusivos',
            description:
                'Concorra a experiências, produtos e surpresas da marca.',
            icon: 'gift',
        },
        {
            title: 'Cidades participantes',
            description:
                'Promoção válida nas principais capitais e regiões do país.',
            icon: 'map',
        },
        {
            title: 'Plataforma segura',
            description:
                'Seus dados protegidos com autenticação e histórico completo.',
            icon: 'shield',
        },
    ] satisfies CampaignFeature[],
    steps: [
        {
            step: 1,
            title: 'Crie sua conta',
            description: 'Cadastre-se gratuitamente com e-mail e senha.',
        },
        {
            step: 2,
            title: 'Compre e guarde o ticket',
            description:
                'Adquira produtos participantes e conserve o comprovante.',
        },
        {
            step: 3,
            title: 'Registre na plataforma',
            description: 'Envie os dados do ticket na área do participante.',
        },
        {
            step: 4,
            title: 'Acompanhe e concorra',
            description: 'Veja seu histórico e fique por dentro das novidades.',
        },
    ] satisfies CampaignStep[],
    cta: {
        title: 'Pronto para participar?',
        description:
            'Cadastre-se agora e comece a registrar seus tickets na campanha Coca-Cola.',
        primaryCta: 'Criar conta grátis',
        secondaryCta: 'Já tenho conta',
    },
} as const;
