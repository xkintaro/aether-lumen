<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Slider extends Model
{
    use Translatable;

    protected $table = 'sliders';

    protected $translatable = [
        'title',
        'subtitle',
        'excerpt',
        'action_text',
        'action_link'
    ];
}
