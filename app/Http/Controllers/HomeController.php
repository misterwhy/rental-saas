<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured properties (active properties with good ratings)
        $featuredProperties = Property::where('is_active', true)
            ->with(['images', 'landlord'])
            ->latest()
            ->limit(6)
            ->get();

        return view('home', compact('featuredProperties'));
    }
}