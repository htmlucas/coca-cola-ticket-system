export type TicketStatus = 'pending' | 'approved' | 'rejected';

export type StatusOption = {
    value: TicketStatus;
    label: string;
};

export type TicketSummary = {
    id: number;
    serial_number: string;
    status: TicketStatus;
    status_label: string;
    rejection_reason: string | null;
    proof_image_url: string;
    city: {
        id?: number;
        name: string;
        state: string;
    };
    user?: {
        id: number;
        name: string;
        email: string;
        cpf: string;
    };
    reviewer?: {
        id: number;
        name: string;
    } | null;
    created_at: string | null;
    reviewed_at?: string | null;
};

export type StatusCount = {
    status: TicketStatus;
    label: string;
    total: number;
};

export type Paginated<T> = {
    data: T[];
    links: Array<{
        url: string | null;
        label: string;
        active: boolean;
    }>;
    from: number | null;
    to: number | null;
    total: number;
};
