<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Counter extends Model
{
    use Translatable;

    protected $table = 'counters';

    protected $translatable = ['title'];
}
