<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;
    protected $table = 'reward';
    protected $fillable = [
        'name',
        'image',
        'description',
        'point',
        'terms',
        'howto',
        'store',
        'start_date_time',
        'end_date_time'
    ];

    protected $casts = [
        'point' => 'integer',
    ];

    public function getImageAttribute($value)
    {
        if (!empty($value) && file_exists(public_path('reward/' . $value))) {
            return url('/reward/' . $value);
        } else {
            return url('/images/default.jpg');
        }
    }

    public function category()
    {
        return $this->belongsTo(CategoryReward::class, 'category_reward_id', 'id');
    }
}
