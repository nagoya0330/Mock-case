<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $page = request('page', 'sell');

        if ($page === 'buy') {
            $items = $user->purchases()->with('item')->get()->pluck('item');
        } else {
            $items = $user->items;
        }

        return view('mypage.profile.profile', compact('user', 'items', 'page'));
    }
}