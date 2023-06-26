<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise_id',
        'distance',
    ];

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
