<?php

namespace Pine\Policy\Tests;

use Pine\Policy\UsesModelName;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, UsesModelName;

    protected $guarded = [];
}
