<?php

namespace App\Services;

/**
 * Cálculo de costes de envío por zonas (desde Monistrol de Montserrat).
 * Zonas según destino en España.
 */
class ShippingCostService
{
    public const ZONE_1 = 1;   // Barcelona
    public const ZONE_2 = 2;   // Girona, Tarragona, Lleida
    public const ZONE_3 = 3;   // Península (media)
    public const ZONE_3_PLUS = 4;  // Península (larga distancia) - mismo precio que Zona 3
    public const ZONE_4 = 5;   // Baleares, Ceuta, Melilla
    public const ZONE_5 = 6;   // Canarias

    /** Precios totales por zona (base + IVA + combustible) en euros */
    private static array $prices = [
        self::ZONE_1 => 6.65,
        self::ZONE_2 => 7.59,
        self::ZONE_3 => 7.80,
        self::ZONE_3_PLUS => 7.80,
        self::ZONE_4 => 9.92,
        self::ZONE_5 => 17.61,
    ];

    /** Provincias por zona (nombres normalizados para comparación) */
    private static array $provincesByZone = [
        self::ZONE_1 => ['barcelona'],
        self::ZONE_2 => ['girona', 'tarragona', 'lleida', 'lerida', 'gerona'],
        self::ZONE_4 => [
            'illes balears', 'islas baleares', 'baleares', 'balears',
            'mallorca', 'menorca', 'ibiza', 'eivissa', 'formentera',
            'ceuta', 'melilla',
        ],
        self::ZONE_5 => [
            'santa cruz de tenerife', 'las palmas', 'tenerife', 'gran canaria',
            'lanzarote', 'fuerteventura', 'la palma', 'la gomera', 'el hierro',
            'canarias', 'palmas',
        ],
    ];

    /**
     * Obtiene la zona de envío a partir del nombre de la provincia.
     */
    public static function getZoneFromProvince(string $province): int
    {
        $key = self::normalizeProvince($province);
        if ($key === '') {
            return self::ZONE_3; // Por defecto zona 3 si no se reconoce
        }

        foreach (self::$provincesByZone as $zone => $names) {
            foreach ($names as $name) {
                if ($key === $name || str_contains($key, $name) || str_contains($name, $key)) {
                    return $zone;
                }
            }
        }

        return self::ZONE_3;
    }

    /**
     * Obtiene el precio total de envío (en euros) para una provincia.
     */
    public static function getShippingPriceForProvince(string $province): float
    {
        $zone = self::getZoneFromProvince($province);

        return self::$prices[$zone] ?? self::$prices[self::ZONE_3];
    }

    /**
     * Devuelve información de la zona y precio para una provincia (para API / vista).
     */
    public static function getShippingInfoForProvince(string $province): array
    {
        $zone = self::getZoneFromProvince($province);
        $price = self::$prices[$zone] ?? self::$prices[self::ZONE_3];
        $label = self::getZoneLabel($zone);

        return [
            'zone' => $zone,
            'zone_label' => $label,
            'price' => round($price, 2),
        ];
    }

    /**
     * Etiqueta legible de la zona.
     */
    public static function getZoneLabel(int $zone): string
    {
        return match ($zone) {
            self::ZONE_1 => 'Zona 1 (Barcelona)',
            self::ZONE_2 => 'Zona 2 (Girona, Tarragona, Lleida)',
            self::ZONE_3 => 'Zona 3 (Península)',
            self::ZONE_3_PLUS => 'Zona 3+ (Península larga distancia)',
            self::ZONE_4 => 'Zona 4 (Baleares, Ceuta, Melilla)',
            self::ZONE_5 => 'Zona 5 (Canarias)',
            default => 'Zona 3 (Península)',
        };
    }

    /**
     * Precio mínimo y máximo de envío (para mostrar rango en la tienda).
     */
    public static function getPriceRange(): array
    {
        $prices = array_values(self::$prices);

        return [
            'min' => min($prices),
            'max' => max($prices),
        ];
    }

    /**
     * Todas las zonas con precios (para listados / admin).
     */
    public static function getAllZones(): array
    {
        $result = [];
        foreach (array_keys(self::$prices) as $zone) {
            $result[] = [
                'zone' => $zone,
                'label' => self::getZoneLabel($zone),
                'price' => self::$prices[$zone],
            ];
        }

        return $result;
    }

    private static function normalizeProvince(string $province): string
    {
        $s = trim($province);
        if ($s === '') {
            return '';
        }
        $s = mb_strtolower($s, 'UTF-8');
        $s = self::removeAccents($s);

        return $s;
    }

    private static function removeAccents(string $s): string
    {
        $map = [
            'á' => 'a', 'à' => 'a', 'ä' => 'a', 'â' => 'a', 'ã' => 'a',
            'é' => 'e', 'è' => 'e', 'ë' => 'e', 'ê' => 'e',
            'í' => 'i', 'ì' => 'i', 'ï' => 'i', 'î' => 'i',
            'ó' => 'o', 'ò' => 'o', 'ö' => 'o', 'ô' => 'o', 'õ' => 'o',
            'ú' => 'u', 'ù' => 'u', 'ü' => 'u', 'û' => 'u',
            'ñ' => 'n', 'ç' => 'c',
        ];

        return strtr($s, $map);
    }
}
