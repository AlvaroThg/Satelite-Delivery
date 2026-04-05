<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Store;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $orderService)
    {
    }

    /**
     * GET /api/orders
     * Lista los pedidos del usuario autenticado (según su rol).
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $orders = match ($user->role) {
            'admin'  => Order::with(['client', 'store', 'driver'])->latest()->get(),
            'driver' => Order::where('driver_id', $user->id)
                             ->with(['client', 'store'])
                             ->latest()
                             ->get(),
            default  => Order::where('client_id', $user->id)
                             ->with(['store', 'driver'])
                             ->latest()
                             ->get(),
        };

        return OrderResource::collection($orders);
    }

    /**
     * POST /api/orders
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'store_id'       => ['required', 'exists:stores,id'],
            'subtotal'       => ['required', 'numeric', 'min:0'],
            'lat'            => ['required', 'numeric'],
            'lng'            => ['required', 'numeric'],
            'reference_text' => ['required', 'string', 'max:500'],
        ]);

        // Calcular tarifa usando la ubicación de la tienda
        $store       = Store::findOrFail($data['store_id']);
        $deliveryFee = $this->orderService->calculateFee(
            $store->lat, $store->lng,
            $data['lat'],  $data['lng']
        );

        $order = Order::create([
            ...$data,
            'client_id'    => $request->user()->id,
            'delivery_fee' => $deliveryFee,
            'total'        => $data['subtotal'] + $deliveryFee,
            'status'       => 'pending',
        ]);

        return new OrderResource($order->load(['client', 'store']));
    }

    /**
     * GET /api/orders/{order}
     */
    public function show(Order $order)
    {
        return new OrderResource($order->load(['client', 'store', 'driver']));
    }

    /**
     * PATCH /api/orders/{order}/status
     * Actualiza el estado del pedido (driver o admin).
     */
    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,accepted,on_way,delivered'],
        ]);

        // Si un driver acepta el pedido → se asigna automáticamente
        if ($data['status'] === 'accepted' && is_null($order->driver_id)) {
            $order->driver_id = $request->user()->id;
        }

        $order->update($data);

        return new OrderResource($order->load(['client', 'store', 'driver']));
    }
}
