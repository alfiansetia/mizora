<?php

namespace App\Models;

use App\Models\CategoryMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    use HasFactory;

    protected $table = 'message';

    protected $guarded = ['id'];

    public function getImageAttribute($value)
    {
        $base_url = 'https://assets.mizora.jewelry/appmob/';
        $path = 'message/';
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
        return $this->belongsTo(CategoryMessage::class, 'category_message_id', 'id');
    }
}
