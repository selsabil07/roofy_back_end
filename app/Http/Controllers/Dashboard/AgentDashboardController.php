<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Roofy API: Agent dashboard stats and own-listing management for the agent SPA.
 */
class AgentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $agent = $request->user();

        $stats = [
            'total_listings' => $agent->properties()->count(),
            'available_listings' => $agent->properties()->where('availability', true)->count(),
            'for_sale' => $agent->properties()->where('status', 'sell')->count(),
            'for_rent' => $agent->properties()->where('status', 'rent')->count(),
        ];

        $recentProperties = $agent->properties()->latest()->take(5)->get();

        return response()->json([
            'stats' => $stats,
            'recent_properties' => PropertyResource::collection($recentProperties),
        ]);
    }

    public function properties(Request $request): AnonymousResourceCollection
    {
        $properties = $request->user()
            ->properties()
            ->with('user')
            ->latest()
            ->paginate($request->integer('per_page', 15));

        return PropertyResource::collection($properties);
    }
}
