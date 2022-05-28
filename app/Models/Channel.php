<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * Query scopes.
     */
    public function scopeIsNotDefault($query) 
    {
        $query->where('is_default', false);
    }
}
