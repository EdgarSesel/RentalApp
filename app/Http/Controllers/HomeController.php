<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function login(Request $request) {
        // Your login logic here
        return view('home');
    }


public function index(Request $request)
{
    $search = $request->query('search');
    $sortParam = explode('|', $request->query('sort', 'name|asc'));
    $sortField = $sortParam[0];
    $sortDirection = $sortParam[1] ?? 'asc';

    $products = Product::with('images')->when($search, function ($query) use ($search) {
        return $query->where('name', 'like', '%' . $search . '%');
    })->orderBy($sortField, $sortDirection)->paginate(5);

    return view('products.index', compact('products', 'search'));
}


    public function logout()
    {
        // Your logout logic here
        return redirect()->route('login');
    }

}
