<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Station extends Model
{

    protected $appends = [
        'name',
    ];

    public function state(): BelongsTo
    {
        return $this->belongsTo('App\State');
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