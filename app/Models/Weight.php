<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise_id',
        'weight'
    ];

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
