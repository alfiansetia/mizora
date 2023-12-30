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
        $base_url = 'https://assets.mizora.jewelry/appmob/';
        $path = 'reward/';
        $public_path = '/var/www/mizoraadm/public/images/';
        $default_img = 'default.jpg';
        if (!empty($value) && file_exists($public_path . $path . $value)) {
            return $base_url . $path . $value;
        } else {
            return $base_url . $default_img;
        }
    }

    public function category()
    {
        return $this->belongsTo(CategoryReward::class, 'category_reward_id', 'id');
    }
}
