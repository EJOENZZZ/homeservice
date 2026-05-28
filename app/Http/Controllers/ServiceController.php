<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Professional::where('is_active', true);

            if ($request->filled('service')) {
                $query->where('specialty', 'like', '%'.$request->service.'%');
            }

            if ($request->filled('location')) {
                $query->where('location', 'like', '%'.$request->location.'%');
            }

            $professionals = $query->orderByDesc('rating')->get();
        } catch (\Exception $e) {
            $professionals = collect();
        }

        return view('pages.services', compact('professionals'));
    }
}