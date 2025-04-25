<?php
namespace App\Enum;

enum BookingStatus: string
{
    case PENDING = 'pending';     // En attente
    case ACCEPTED = 'accepted';   // Acceptée
    case REFUSED = 'refused';     // Refusée
    case BLOCKED = 'blocked';     // Bloqué

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::ACCEPTED => 'Acceptée',
            self::REFUSED => 'Refusée',
            self::BLOCKED => 'Bloquée',
        };
    }
}
