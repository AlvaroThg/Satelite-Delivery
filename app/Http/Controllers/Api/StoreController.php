<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * GET /api/stores
     */
    public function index()
    {
        return StoreResource::collection(
            Store::with('owner')->latest()->get()
        );
    }

    /**
     * POST /api/stores
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'lat'       => ['required', 'numeric'],
            'lng'       => ['required', 'numeric'],
            'image_url' => ['nullable', 'url'],
        ]);

        $store = Store::create([
            ...$data,
            'user_id' => $request->user()->id,
        ]);

        return new StoreResource($store);
    }

    /**
     * GET /api/stores/{store}
     */
    public function show(Store $store)
    {
        return new StoreResource($store->load(['owner', 'products']));
    }

    /**
     * PUT /api/stores/{store}
     */
    public function update(Request $request, Store $store)
    {
        $data = $request->validate([
            'name'      => ['sometimes', 'string', 'max:255'],
            'lat'       => ['sometimes', 'numeric'],
            'lng'       => ['sometimes', 'numeric'],
            'image_url' => ['nullable', 'url'],
        ]);

        $store->update($data);

        return new StoreResource($store);
    }
}
