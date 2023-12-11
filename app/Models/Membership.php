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
        'transaction_from'  => 'integer',
        'transaction_to'    => 'integer',
    ];

    public function getImageAttribute($value)
    {
        if (!empty($value) && file_exists(public_path('memberships/' . $value))) {
            return url('/memberships/' . $value);
        } else {
            return url('/images/default.jpg');
        }
    }
}
