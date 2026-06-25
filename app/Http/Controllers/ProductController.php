<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    private function authorizeAdmin(): void
    {
        abort_if(auth()->user()->role !== 'admin', 403);
    }

    public function index(Request $request)
    {
        $search = $request->query('search');

        $products = Product::with('brand')
            ->when($search, function ($query, $search) {
                $query->where('model_name', 'like', "%{$search}%")
                    ->orWhereHas('brand', function ($query) use ($search) {
                        $query->where('brand_name', 'like', "%{$search}%");
                    });
            })
            ->latest('product_id')
            ->paginate(12)
            ->withQueryString();

        return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        $brands = Brand::orderBy('brand_name')->get();

        return view('products.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'brand_id' => 'nullable|integer|exists:brands,brand_id|required_without:brand_name',
            'brand_name' => 'nullable|string|max:150|required_without:brand_id',
            'model_name' => 'required|string|max:150',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'image_url' => 'nullable|url|max:1000',
            'stock' => 'required|integer|min:0',
            'release_year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
        ]);

        if (!empty($validated['brand_name'])) {
            $brand = Brand::firstOrCreate(['brand_name' => $validated['brand_name']]);
            $validated['brand_id'] = $brand->brand_id;
        }

        unset($validated['brand_name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('product-images', 'public');
        } elseif (!empty($validated['image_url'])) {
            $validated['image'] = $validated['image_url'];
        }

        unset($validated['image_url']);

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
        $this->authorizeAdmin();

        $brands = Brand::orderBy('brand_name')->get();

        return view('products.edit', compact('product', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'brand_id' => 'nullable|integer|exists:brands,brand_id|required_without:brand_name',
            'brand_name' => 'nullable|string|max:150|required_without:brand_id',
            'model_name' => 'required|string|max:150',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'image_url' => 'nullable|url|max:1000',
            'stock' => 'required|integer|min:0',
            'release_year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
        ]);

        if (!empty($validated['brand_name'])) {
            $brand = Brand::firstOrCreate(['brand_name' => $validated['brand_name']]);
            $validated['brand_id'] = $brand->brand_id;
        }

        unset($validated['brand_name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('product-images', 'public');
        } elseif (!empty($validated['image_url'])) {
            $validated['image'] = $validated['image_url'];
        }

        unset($validated['image_url']);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $this->authorizeAdmin();

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'selected_products' => 'required|array|min:1',
            'selected_products.*' => 'integer|distinct|exists:products,product_id',
        ]);

        Product::whereIn('product_id', $validated['selected_products'])->delete();

        return redirect()->route('products.index')->with('success', 'Produk terpilih berhasil dihapus.');
    }
}
