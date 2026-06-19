<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

/**
 * Roofy API: Public browse + authenticated CRUD with pagination, filters, and policies.
 */
class PropertyController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Property::query()->with('user');

        if (! $request->user() || $request->user()->isUser()) {
            $query->where('availability', true);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%'.$request->location.'%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%')
                    ->orWhere('location', 'like', '%'.$request->search.'%');
            });
        }

        $properties = $query->latest()->paginate($request->integer('per_page', 15));

        return PropertyResource::collection($properties);
    }

    public function show(Property $property): PropertyResource
    {
        $property->load('user');

        return new PropertyResource($property);
    }

    public function store(StorePropertyRequest $request): JsonResponse
    {
        $userId = $request->user()->id;

        if ($request->user()->isAdmin() && $request->filled('user_id')) {
            $userId = $request->integer('user_id');
        }

        $property = Property::create([
            ...$request->safe()->except('user_id'),
            'user_id' => $userId,
            'availability' => $request->boolean('availability', true),
        ]);

        $property->load('user');

        return response()->json([
            'message' => 'Property created successfully',
            'property' => new PropertyResource($property),
        ], 201);
    }

    public function update(UpdatePropertyRequest $request, Property $property): JsonResponse
    {
        $property->update($request->validated());
        $property->load('user');

        return response()->json([
            'message' => 'Property updated successfully',
            'property' => new PropertyResource($property),
        ]);
    }

    public function destroy(Property $property): JsonResponse
    {
        $this->authorize('delete', $property);

        $property->delete();

        return response()->json(['message' => 'Property deleted successfully']);
    }
}
