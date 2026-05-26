<?php

namespace App\Http\Controllers;

use App\Models\Professional;

class ProfessionalController extends Controller
{
    public function show($id)
    {
        $pro = Professional::findOrFail($id);
        return view('pages.pro-detail', compact('pro'));
    }
}