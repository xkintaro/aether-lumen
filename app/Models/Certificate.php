<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Certificate extends Model
{
    use Translatable;

    protected $translatable = [
        'title',
        'organization',
        'description'
    ];

    protected $casts = [
        'received_at' => 'datetime',
    ];
}
