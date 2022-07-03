<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_number',
        'user_id',
        'start_date',
        'end_date',
    ];

    /**
     * Relationships.
     */
    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Query scopes.
     */
    public function scopeNextMonthDue($query) 
    {
        $query->where('end_date', now()->addMonths(1)->toDateString());
    }
}
