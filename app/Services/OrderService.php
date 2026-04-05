<?php

namespace App\Services;

class OrderService
{
    /**
     * Calcula el costo de delivery usando la Fórmula de Distancia Euclidiana.
     *
     * Los parámetros son coordenadas geográficas en grados decimales.
     * La distancia se aproxima a kilómetros usando el factor de escala
     * estándar para la región (1 grado ≈ 111 km).
     *
     * Tarifas:
     *   < 1.5 km →  5 Bs
     *   < 3.5 km →  8 Bs
     *  >= 3.5 km → 12 Bs
     *
     * @param float $lat1  Latitud del origen  (tienda)
     * @param float $lng1  Longitud del origen (tienda)
     * @param float $lat2  Latitud del destino (cliente)
     * @param float $lng2  Longitud del destino (cliente)
     * @return float       Tarifa en Bolivianos
     */
    public function calculateFee(
        float $lat1,
        float $lng1,
        float $lat2,
        float $lng2
    ): float {
        // ── Fórmula Euclidiana ─────────────────────────────────────────
        //  d = √( (Δlat)² + (Δlng)² ) × 111 km/grado
        $deltaLat = $lat2 - $lat1;
        $deltaLng = $lng2 - $lng1;

        $distanceKm = sqrt(($deltaLat ** 2) + ($deltaLng ** 2)) * 111;

        // ── Tarifas por zona ──────────────────────────────────────────
        return match (true) {
            $distanceKm < 1.5 => 5.0,
            $distanceKm < 3.5 => 8.0,
            default           => 12.0,
        };
    }
}
