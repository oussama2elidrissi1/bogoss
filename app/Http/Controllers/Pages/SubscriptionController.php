<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = Subscription::orderByDesc('popular')->orderBy('price')->get();

        return view('pages.subscriptions', [
            'plans' => $plans,
        ]);
    }

    public function subscribe(Subscription $subscription)
    {
        return redirect()->route('subscriptions')->with('success', "Subscription to {$subscription->name} plan initiated. (Demo mode)");
    }
}
