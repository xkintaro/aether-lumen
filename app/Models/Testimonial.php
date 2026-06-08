<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Testimonial extends Model
{
    use Translatable;

    protected $translatable = [
        'title',
        'comment'
    ];
}
