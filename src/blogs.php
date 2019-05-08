<?php

namespace Hosein\Blogs;

use Illuminate\Database\Eloquent\Model;

class blogs extends Model
{
    protected $fillable=[
        'id',
        'title',
        'summery',
        'details',
        'image',
        'author',
        'categoryBlogs',
        'like',
        'disLike',
        'visited'
    ];
}
