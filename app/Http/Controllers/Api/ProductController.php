<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * GET /api/stores/{store}/products
     */
    public function index(int $storeId)
    {
        return ProductResource::collection(
            Product::where('store_id', $storeId)->get()
        );
    }

    /**
     * POST /api/stores/{store}/products
     */
    public function store(Request $request, int $storeId)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'image_url'   => ['nullable', 'url'],
        ]);

        $product = Product::create([...$data, 'store_id' => $storeId]);

        return new ProductResource($product);
    }

    /**
     * PUT /api/products/{product}
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => ['sometimes', 'string'],
            'description' => ['nullable', 'string'],
            'price'       => ['sometimes', 'numeric', 'min:0'],
            'image_url'   => ['nullable', 'url'],
        ]);

        $product->update($data);

        return new ProductResource($product);
    }

    /**
     * DELETE /api/products/{product}
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Producto eliminado.']);
    }
}
