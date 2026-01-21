<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('available', true)->take(6)->get() ?? collect([]);
        $products = Product::where('in_stock', true)->take(3)->get() ?? collect([]);
        $subscriptions = Subscription::all() ?? collect([]);
        
        return view('home', compact('services', 'products', 'subscriptions'));
    }
}
