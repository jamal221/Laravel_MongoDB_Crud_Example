<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use MongoDB\Laravel\Eloquent\Model;
// use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model;


class userinf extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'users';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'NameUser',
        'UserEmail',
        'UserMobile',
        'Status'
    ];
}
