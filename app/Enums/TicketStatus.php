<?php

namespace App\Enums;

enum TicketStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @param  array<string, int>  $counts
     * @return array<int, array<string, mixed>>
     */
    public static function casesAsStatusCounts(array $counts): array
    {
        return array_map(fn (self $status): array => [
            'status' => $status->value,
            'label' => $status->label(),
            'total' => $counts[$status->value] ?? 0,
        ], self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendente',
            self::Approved => 'Aprovado',
            self::Rejected => 'Rejeitado',
        };
    }
}
