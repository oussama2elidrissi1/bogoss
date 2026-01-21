<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('q', ''));
        $category = $request->get('category', 'All');

        $servicesQuery = Service::query()->where('available', true);

        if ($category !== 'All') {
            $servicesQuery->where('category', $category);
        }

        if ($search !== '') {
            $servicesQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $services = $servicesQuery->orderBy('name')->get();
        $categories = Service::query()->select('category')->distinct()->orderBy('category')->pluck('category');

        return view('pages.services', [
            'services' => $services,
            'categories' => $categories,
            'selectedCategory' => $category,
            'searchQuery' => $search,
        ]);
    }
}
