<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'slider';

    protected $guarded = ['id'];

    public function getImageAttribute($value)
    {
        if (!empty($value) && file_exists(public_path('slider/' . $value))) {
            return url('/images/slider/' . $value);
        } else {
            return url('/images/default.jpg');
        }
    }
}
