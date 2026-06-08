<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\CacheManagerService;

class Redirect301 extends Model
{
    use HasFactory;

    protected $table = 'redirect_301s';

    protected $fillable = [
        'old_url',
        'new_url',
        'status',
    ];
}
