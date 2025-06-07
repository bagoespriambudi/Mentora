<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
>>>>>>> origin/Aida

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
<<<<<<< HEAD
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
=======
        'is_active',
    ];

    // Placeholder for services relationship
    public function services()
    {
        return $this->hasMany(Service::class);
    }
} 
>>>>>>> origin/Aida
