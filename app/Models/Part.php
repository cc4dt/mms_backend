<?php

namespace App\Models;

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
        return $this->hasMany(SubPart::class);
    }

    public function procedures(): BelongsToMany
    {
        return $this->belongsToMany(MaintenanceProcedure::class);
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
