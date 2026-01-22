<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Service;

class PacksController extends Controller
{
    public function index()
    {
        $packs = Service::query()
            ->whereIn('category', ['Pack', 'Packages'])
            ->orderBy('name')
            ->get();

        return view('pages.packs', [
            'packs' => $packs,
        ]);
    }
}
