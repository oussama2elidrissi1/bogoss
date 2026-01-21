<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('q', ''));
        $category = $request->get('category', 'All');
        $stock = $request->get('stock', 'all');

        $query = Product::query();

        if ($category !== 'All') {
            $query->where('category', $category);
        }

        if ($search !== '') {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($stock === 'in-stock') {
            $query->where('in_stock', true);
        } elseif ($stock === 'out-of-stock') {
            $query->where('in_stock', false);
        }

        $products = $query->orderBy('name')->get();
        $categories = Product::query()->select('category')->distinct()->orderBy('category')->pluck('category');

        return view('admin.products', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $category,
            'searchQuery' => $search,
            'stockFilter' => $stock,
        ]);
    }
}
