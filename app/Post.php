<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    //
    use SoftDeletes;
    protected $table = 'posts';
    protected $id   = 'id';
    protected $fillable = [
        'title',
        'content'
    ];
    protected $dates = ['deleted_at'];
}
