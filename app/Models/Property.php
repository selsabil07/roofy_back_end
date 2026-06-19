<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Roofy API: Property listing owned by an agent (user_id).
 * Added casts, user_id fillable, and factory binding.
 */
class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'status',
        'availability',
        'description',
        'totalArea',
        'floor',
        'location',
        'rooms',
        'bathrooms',
        'price',
        'documents',
    ];

    protected $casts = [
        'availability' => 'boolean',
        'totalArea' => 'float',
        'floor' => 'integer',
        'rooms' => 'integer',
        'bathrooms' => 'integer',
        'price' => 'float',
        'documents' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
