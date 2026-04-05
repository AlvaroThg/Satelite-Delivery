<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Actores
            $table->foreignId('client_id')
                  ->constrained('users')
                  ->onDelete('restrict');
            $table->foreignId('store_id')
                  ->constrained()
                  ->onDelete('restrict');
            $table->foreignId('driver_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            // Montos
            $table->decimal('subtotal', 10, 2);
            $table->decimal('delivery_fee', 8, 2);
            $table->decimal('total', 10, 2);

            // Ubicación de entrega
            $table->decimal('lat', 10, 8);
            $table->decimal('lng', 11, 8);
            $table->string('reference_text');           // obligatorio

            // Estado del pedido
            $table->enum('status', ['pending', 'accepted', 'on_way', 'delivered'])
                  ->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
