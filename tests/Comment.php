<?php

namespace Pine\Translatable\Tests;

use Pine\Policy\UsesModelName;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use UsesModelName;

    protected $append = ['model_name'];

    protected $fillable = [
        'user_id',
        'body',
    ];
}
