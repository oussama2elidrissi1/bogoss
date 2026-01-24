<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Service;
use Illuminate\Support\Carbon;

class PacksController extends Controller
{
    public function index()
    {
        $query = Service::query()
            ->where('available', true)
            ->whereNotIn('category', ['Pack', 'Packages', 'Produits']);

        // Filtre par catégorie
        if (request()->filled('category') && request('category') !== 'all') {
            $query->where('category', request('category'));
        }

        // Filtre par recherche
        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $services = $query->orderBy('category')->orderBy('name')->get();

        // Récupérer toutes les catégories disponibles
        $categories = Service::query()
            ->where('available', true)
            ->whereNotIn('category', ['Pack', 'Packages', 'Produits'])
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $today = Carbon::today();
        $promotions = Promotion::query()
            ->where('status', 'active')
            ->whereDate('valid_from', '<=', $today)
            ->whereDate('valid_until', '>=', $today)
            ->orderBy('valid_until')
            ->get();

        return view('pages.packs', [
            'services' => $services,
            'promotions' => $promotions,
            'categories' => $categories,
            'selectedCategory' => request('category', 'all'),
            'searchQuery' => request('search', ''),
        ]);
    }
}
