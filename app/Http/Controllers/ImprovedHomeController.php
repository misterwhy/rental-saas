<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache featured properties for 30 minutes
        $featuredProperties = Cache::remember('featured_properties', 1800, function () {
            return Property::where('is_active', true)
                ->with(['landlord', 'images'])
                ->latest()
                ->limit(6)
                ->get();
        });

        // Get property statistics
        $stats = Cache::remember('property_stats', 3600, function () {
            return [
                'total_properties' => Property::where('is_active', true)->count(),
                'total_cities' => Property::where('is_active', true)->distinct('city')->count(),
                'average_price' => Property::where('is_active', true)->avg('price_per_night'),
            ];
        });

        return view('home', compact('featuredProperties', 'stats'));
    }

    public function search(Request $request)
    {
        $query = Property::where('is_active', true)->with('landlord');

        // Location search with fallback to multiple fields
        if ($request->filled('location')) {
            $location = $request->location;
            $query->where(function($q) use ($location) {
                $q->where('city', 'LIKE', "%{$location}%")
                  ->orWhere('state', 'LIKE', "%{$location}%")
                  ->orWhere('address', 'LIKE', "%{$location}%");
            });
        }

        // Price range filtering
        if ($request->filled('min_price')) {
            $query->where('price_per_night', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_night', '<=', $request->max_price);
        }

        // Guest capacity filtering
        if ($request->filled('guests')) {
            $query->where('max_guests', '>=', $request->guests);
        }

        // Property type filtering
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        // Amenities filtering
        if ($request->filled('amenities') && is_array($request->amenities)) {
            foreach ($request->amenities as $amenity) {
                $query->whereJsonContains('amenities', $amenity);
            }
        }

        // Sorting
        switch ($request->get('sort_by', 'latest')) {
            case 'price_low':
                $query->orderBy('price_per_night', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_per_night', 'desc');
                break;
            case 'guests':
                $query->orderBy('max_guests', 'desc');
                break;
            default:
                $query->latest();
        }

        $properties = $query->paginate(config('property.defaults.pagination_limit', 12));

        // Keep search parameters in pagination links
        $properties->appends($request->query());

        return view('properties.index', compact('properties'));
    }
}
