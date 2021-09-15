<?php

namespace Goyan\Bs2\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $connection = 'mysql2';

    public $timestamps = false;

    protected $fillable = [
        'base_url',
        'api_key',
        'api_secret',
        'access_token',
        'refresh_token',
        'scope',
        'status',
    ];

    protected $primaryKey = 'id';
    protected $table = 'Token';
}
