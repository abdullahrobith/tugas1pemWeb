<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Categories;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $product = Product::query();

        if ($request->filled('search')) {
            $product->where('name', 'like', '%' . $request->search . '%');
        }

        return view('dashboard.product.index', [
            'product' => $product->paginate(10),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::all();
        return view('dashboard.product.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'sku' => 'required|string|max:100|unique:product,sku',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'required|exists:product_categories,id',
            'image_url' => 'nullable|url',
            'is_active' => 'required|boolean'
        ]);

        // Simpan data produk
        $product = new Product;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->product_category_id = $request->product_category_id;
        $product->image_url = $request->image_url;
        $product->is_active = $request->is_active;
        $product->save();

        return redirect()->route('product.index')->with('successMessage', 'Data produk berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Categories::all();

        return view('dashboard.product.edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'sku' => 'required|string|max:100|unique:product,sku,' . $id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'required|exists:product_categories,id',
            'image_url' => 'nullable|url',
            'is_active' => 'required|boolean'
        ]);

        // Simpan data produk
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->product_category_id = $request->product_category_id;
        $product->image_url = $request->image_url;
        $product->is_active = $request->is_active;
        $product->save();

        return redirect()->route('product.index')->with('successMessage', 'Data produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('successMessage', 'Data produk berhasil dihapus.');
    }
}