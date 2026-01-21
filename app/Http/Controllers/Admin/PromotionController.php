<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('q', ''));
        $status = $request->get('status', 'All');

        $query = Promotion::query();

        if ($status !== 'All') {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $promotions = $query->orderBy('valid_from', 'desc')->get();

        return view('admin.promotions', [
            'promotions' => $promotions,
            'searchQuery' => $search,
            'statusFilter' => $status,
        ]);
    }
}
