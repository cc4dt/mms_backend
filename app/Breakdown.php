<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Breakdown extends Model
{

    protected $appends = [
        'name',
    ];


    public function equipment(): BelongsTo
    {
        return $this->belongsTo('App\Equipment');
    }

    public function getNameAttribute($value)
    {
        return $this->{'name_' . app()->getlocale()};
    }

    public function setNameAttribute($value)
    {
        $this->{'name_' . app()->getlocale()} = $value;
    }
}