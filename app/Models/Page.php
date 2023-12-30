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
        $base_url = 'https://assets.mizora.jewelry/appmob/';
        $path = 'pages/';
        $public_path = '/var/www/mizoraadm/public/images/';
        $default_img = 'default.jpg';
        if (!empty($value) && file_exists($public_path . $path . $value)) {
            return $base_url . $path . $value;
        } else {
            return $base_url . $default_img;
        }
    }
}
