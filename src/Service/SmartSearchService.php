<?php
// src/Service/SmartSearchService.php
namespace App\Service;

class SmartSearchService
{
    public function parseQuery(string $query): array
    {
        $criteria = [];

        // Détecte la ville avec "à {ville}"
        if (preg_match('/à ([\p{L}\s\-]+)/u', $query, $matches)) {
            $criteria['city'] = trim($matches[1]);
        }

        // Liste simple de mots-clés à détecter
        $features = ['piscine', 'spa', 'jacuzzi', 'wifi', 'vue mer'];
        $queryLower = mb_strtolower($query);
        foreach ($features as $feature) {
            if (str_contains($queryLower, $feature)) {
                $criteria['keywords'][] = $feature;
            }
        }

        return $criteria;
    }
}
