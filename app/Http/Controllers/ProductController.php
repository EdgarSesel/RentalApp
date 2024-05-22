<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    // Method to display the form for adding a new product
    public function create()
    {
        return view('products.create');
    }

public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
        'image' => 'required|image', // Validate the image
    ]);

    // Create a new product
    $product = new Product(); // Adjusted to use the full namespace
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->user_id = Auth::id(); // Add the user_id
    $product->save(); // Save the product to get an ID

    // Handle the image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products_images', 'public');

        // Create a new ProductImage and associate it with the product
        $productImage = new ProductImage();
        $productImage->product_id = $product->id; // Associate with the product
        $productImage->image_path = $imagePath;
        $productImage->save();
    }

    // Redirect to the product list page
    return redirect()->route('products.index');
}

    public function index(Request $request)
    {
        $search = $request->query('search');
        $sortParam = explode('|', $request->query('sort', 'name|asc'));
        $sortField = $sortParam[0];
        $sortDirection = $sortParam[1] ?? 'asc';

        $products = Product::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->orderBy($sortField, $sortDirection)->paginate(5);

        return view('products.index', compact('products', 'search'));
    }

    public function show(Product $product)
    {
        $product->load('user');
        return view('products.show', compact('product'));
    }

    public function rent(Product $product)
{
    if (Auth::id() == $product->user_id) {
        return redirect()->back()->with('error', 'You cannot rent your own product.');
    }

    return view('products.rent', compact('product'));
}

    public function myProducts()
    {
        $products = Product::where('user_id', Auth::id())->get();

        return view('products.my', ['products' => $products]);
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->except('_token', '_method');
        $product->update($data);

        return redirect()->route('products.index');
    }

    public function manage()
    {
        $products = Product::paginate(10);
return view('products.manage', compact('products'));
    }
}
