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
        // $path = '/var/www/mizoraadm/public/sliders/';
        // $from = $path . $value;
        // $dest = public_path('sliders/' . $value);
        // if (!empty($value) && file_exists($path . $value) && !file_exists($dest)) {
        //     if (!file_exists(public_path('sliders/'))) {
        //         mkdir(public_path('sliders/'), 0775, true);
        //     }
        //     copy($from, $dest);
        // }
        if (!empty($value) && file_exists(public_path('sliders/' . $value))) {
            return url('sliders/' . $value);
        } else {
            return url('/images/default.jpg');
        }
    }
}
