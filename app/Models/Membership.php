<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $table = 'level_point';

    protected $guarded = ['id'];

    protected $casts = [
        'expiry'            => 'integer',
        'active_membership' => 'integer',
    ];
}
