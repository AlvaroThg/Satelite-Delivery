<?php
/**
 * Debug Script: Listar Tiendas
 * Uso: php debug-stores.php desde el contenedor
 */

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$stores = \App\Models\Store::with('owner')
    ->select('id', 'name', 'lat', 'lng')
    ->limit(5)
    ->get();

echo "═══════════════════════════════════════════════════════════════\n";
echo "  5 TIENDAS EN LA BASE DE DATOS (Conexión Backend-DB Exitosa)\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

foreach ($stores as $store) {
    echo "ID: {$store->id}\n";
    echo "Nombre: {$store->name}\n";
    echo "Latitud: {$store->lat}\n";
    echo "Longitud: {$store->lng}\n";
    echo "Propietario: " . ($store->owner ? $store->owner->name : 'Sin asignar') . "\n";
    echo "───────────────────────────────────────────────────────────\n\n";
}

echo "✓ Total de tiendas: " . $stores->count() . "\n";
echo "✓ Conexión a la BD: EXITOSA\n";
echo "═══════════════════════════════════════════════════════════════\n";
