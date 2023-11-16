<?php

namespace App\Models;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryMessage extends Model
{
    use HasFactory;

    protected $table = 'category_message';

    protected $guarded = ['id'];
}
