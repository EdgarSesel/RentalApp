<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expired_at',
        // other fields as necessary...
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
