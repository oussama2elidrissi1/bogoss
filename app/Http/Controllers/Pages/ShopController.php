<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('q', ''));
        $category = $request->get('category', 'All');

        $productsQuery = Product::query();

        if ($category !== 'All') {
            $productsQuery->where('category', $category);
        }

        if ($search !== '') {
            $productsQuery->where('name', 'like', "%{$search}%");
        }

        $products = $productsQuery->orderBy('name')->get();
        $categories = Product::query()->select('category')->distinct()->orderBy('category')->pluck('category');

        $cart = collect(session('cart', []));
        $cartTotal = $cart->sum(fn ($item) => $item['price'] * $item['quantity']);
        $cartItemsCount = $cart->sum(fn ($item) => $item['quantity']);

        return view('pages.shop', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $category,
            'searchQuery' => $search,
            'cart' => $cart,
            'cartTotal' => $cartTotal,
            'cartItemsCount' => $cartItemsCount,
        ]);
    }

    public function add(Product $product)
    {
        $cart = collect(session('cart', []));
        $existing = $cart->firstWhere('id', $product->id);

        if ($existing) {
            $cart = $cart->map(function ($item) use ($product) {
                if ($item['id'] === $product->id) {
                    $item['quantity'] += 1;
                }
                return $item;
            });
        } else {
            $cart->push([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
            ]);
        }

        session(['cart' => $cart->values()->all()]);

        return redirect()->route('shop');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart = collect(session('cart', []));
        $cart = $cart->map(function ($item) use ($product, $request) {
            if ($item['id'] === $product->id) {
                $item['quantity'] = (int) $request->quantity;
            }
            return $item;
        });

        session(['cart' => $cart->values()->all()]);

        return redirect()->route('shop');
    }

    public function remove(Product $product)
    {
        $cart = collect(session('cart', []));
        $cart = $cart->reject(fn ($item) => $item['id'] === $product->id);

        session(['cart' => $cart->values()->all()]);

        return redirect()->route('shop');
    }

    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('shop');
    }

    public function checkout()
    {
        session()->forget('cart');

        return redirect()->route('shop')->with('success', 'Checkout initiated. (Demo mode)');
    }
}
