<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'image'];

    public function getImageAttribute($value)
    {
        if (!empty($value) && file_exists(public_path('pages/' . $value))) {
            return url('/pages/' . $value);
        } else {
            return url('/images/default.jpg');
        }
    }
}
