<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rep extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise_id',
        'rep',
    ];

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
