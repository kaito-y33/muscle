<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'training_id',
        'user_id',
    ];

    /**
     * Usersテーブルとのリレーション定義.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Trainingsテーブルとのリレーション礼儀.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function trainingByCategory($categoryId)
    {
        return $this->belongsTo(Training::class)
            ->where('category_id', $categoryId);
    }

    public function rep()
    {
        return $this->hasOne(Rep::class)->withDefault([
            'rep' => 0,
        ]);
    }

    public function weight()
    {
        return $this->hasOne(Weight::class)->withDefault([
            'weight' => 0,
        ]);
    }

    public function distance()
    {
        return $this->hasOne(Distance::class)->withDefault([
            'distance' => 0,
        ]);
    }
}
