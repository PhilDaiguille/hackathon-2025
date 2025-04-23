<?php
namespace App\Enum;

enum NegotiationStatus: string
{
    case PENDING = 'pending';     // En attente
    case ACCEPTED = 'accepted';   // Acceptée
    case REFUSED = 'refused';     // Refusée
}
