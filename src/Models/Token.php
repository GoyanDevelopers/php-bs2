<?php

namespace Goyan\Bs2\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'access_token',
        'refresh_token',
        'scope',
        'status',
    ];

    protected $primaryKey = 'id';
    protected $table = 'Token';
}
