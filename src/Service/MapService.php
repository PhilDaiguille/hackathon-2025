<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\UX\Map\Bridge\Leaflet\LeafletOptions;
use Symfony\UX\Map\Bridge\Leaflet\Option\TileLayer;
use Symfony\UX\Map\InfoWindow;
use Symfony\UX\Map\Map;
use Symfony\UX\Map\Marker;
use Symfony\UX\Map\Point;

class MapService
{
    public function createDefaultMap(string $id = 'default', float $lat = 45.7534031, float $lng = 4.8295061, int $zoom = 6): Map
    {
        return (new Map($id))
            ->center(new Point($lat, $lng))
            ->zoom($zoom)
            ->options((new LeafletOptions())
                ->tileLayer(new TileLayer(
                    url: 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',
                    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    options: ['maxZoom' => 19]
                ))
            );
    }

    public function addMarker(Map $map, float $lat, float $lng, string $title, string $content): Map
    {
        return $map->addMarker(new Marker(
            position: new Point($lat, $lng),
            title: $title,
            infoWindow: new InfoWindow(
                content: $content,
            )
        ));
    }

    public function addMarkers(Map $map, array $markers): Map
    {
        foreach ($markers as $marker) {
            $this->addMarker(
                $map,
                $marker['lat'],
                $marker['lng'],
                $marker['title'],
                $marker['content'] ?? ''
            );
        }

        return $map;
    }
}
