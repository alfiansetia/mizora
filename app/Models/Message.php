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
        if (!empty($value) && file_exists(public_path($value))) {
            return url($value);
        } else {
            return url('/images/default.jpg');
        }
    }

    public function category()
    {
        return $this->belongsTo(CategoryMessage::class, 'category_message_id', 'id');
    }
}
