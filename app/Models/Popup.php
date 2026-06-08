<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Popup extends Model
{
    use Translatable;

    protected $translatable = [
        'title',
        'content',
        'action_text',
        'action_link'
    ];
}
    