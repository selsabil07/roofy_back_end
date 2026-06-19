<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\UserResource;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Roofy API: Admin dashboard stats and overview for the admin SPA.
 */
class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'total_users' => User::where('role', User::ROLE_USER)->count(),
            'total_agents' => User::where('role', User::ROLE_AGENT)->count(),
            'total_properties' => Property::count(),
            'available_properties' => Property::where('availability', true)->count(),
            'for_sale' => Property::where('status', 'sell')->count(),
            'for_rent' => Property::where('status', 'rent')->count(),
        ];

        $recentProperties = Property::with('user')->latest()->take(5)->get();
        $recentAgents = User::where('role', User::ROLE_AGENT)->latest()->take(5)->get();

        return response()->json([
            'stats' => $stats,
            'recent_properties' => PropertyResource::collection($recentProperties),
            'recent_agents' => UserResource::collection($recentAgents),
        ]);
    }
}
