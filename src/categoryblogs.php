<?php

namespace Hosein\Blogs;

use Illuminate\Database\Eloquent\Model;

class categoryblogs extends Model
{
    protected $fillable=[
        'id',
        'name',
        'parent',
        'is_parent'
    ];
}
