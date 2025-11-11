<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $products = Product::with('type')
            ->when($q, fn($b) => $b->where('name','like',"%{$q}%"))
            ->paginate(15);
        return response()->json($products);
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $path = $request->file('photo')->store('products', 'public');
        $data['photo_path'] = $path;

        $product = Product::create($data);
        return response()->json($product->load('type'), 201);
    }

    public function show(Product $product)
    {
        return response()->json($product->load('type'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            // delete old
            if ($product->photo_path && Storage::disk('public')->exists($product->photo_path)) {
                Storage::disk('public')->delete($product->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('products', 'public');
        }
        $product->update($data);
        return response()->json($product->load('type'));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
