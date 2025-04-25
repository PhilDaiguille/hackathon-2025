<?php
namespace App\Enum;

enum NegotiationStatus: string
{
    case PENDING = 'pending';     // En attente
    case ACCEPTED = 'accepted';   // Acceptée
    case REFUSED = 'refused';     // Refusée

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::ACCEPTED => 'Acceptée',
            self::REFUSED => 'Refusée',
        };
    }
}
