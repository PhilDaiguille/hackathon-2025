<?php
namespace App\Enum;

enum BookingStatus: string
{
    case PENDING = 'pending';     // En attente
    case ACCEPTED = 'accepted';   // Acceptée
    case REFUSED = 'refused';     // Refusée
    case BLOCKED = 'blocked';     // Bloqué
}
