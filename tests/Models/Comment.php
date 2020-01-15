<?php

namespace Pine\Policy\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Pine\Policy\UsesModelName;

class Comment extends Model
{
    use UsesModelName;

    protected $appends = ['model_name'];
    protected $fillable = ['user_id', 'body'];
}
