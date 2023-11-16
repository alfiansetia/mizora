<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryReward extends Model
{
    use HasFactory;
    protected $table = 'category_reward';
    protected $fillable = [
        'name', 'image'
    ];
    public $timestamps = false;
}
