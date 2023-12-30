<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'location';
    protected $fillable = [
        'name',
        'description',
        'location',
        'street1',
        'street2',
        'postal_code',
        'lat',
        'lng',
        'phone',
        'whatsapp',
        'day_of_week',
        'start_time',
        'end_time',
        'img',
    ];

    public function getImgAttribute($value)
    {
        $base_url = 'https://assets.mizora.jewelry/appmob/';
        $path = 'location/';
        $public_path = '/var/www/mizoraadm/public/images/';
        $default_img = 'default.jpg';
        if (!empty($value) && file_exists($public_path . $path . $value)) {
            return $base_url . $path . $value;
        } else {
            return $base_url . $default_img;
        }
    }
}
