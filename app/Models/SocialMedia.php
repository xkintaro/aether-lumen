<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class SocialMedia extends Model
{
    use Translatable;

    protected $table = 'social_medias';

    protected $translatable = [
        //
    ];
}
