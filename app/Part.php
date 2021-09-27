<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Part extends Model
{
    protected $appends = [
        'name',
    ];

    public function sub_parts(): HasMany
    {   
        return $this->hasMany('App\SubPart');
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany('App\Attribute', 'attribute_part', 'part_id', 'attribute_id');
    }

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
