<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('brand')->orderBy('product_id', 'desc')->paginate(12);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $brands = Brand::orderBy('brand_name')->get();

        return view('products.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,brand_id',
            'model_name' => 'required|string|max:150',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'release_year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        $product->load('brand');

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $brands = Brand::orderBy('brand_name')->get();

        return view('products.edit', compact('product', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'brand_id' => 'required|integer|exists:brands,brand_id',
            'model_name' => 'required|string|max:150',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'release_year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
