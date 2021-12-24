<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SparePart extends Model
{
    protected $fillable = [
        "name_en",
        "name_ar",
    ];
    
    protected $appends = [
        'name',
    ];

    public function getNameAttribute($value)
    {
        return $this->{'name_' . app()->getlocale()};
    }

    public function setNameAttribute($value)
    {
        $this->{'name_' . app()->getlocale()} = $value;
    }

    public function sub_parts(): HasMany
    {   
        return $this->hasMany(SpareSubPart::class, 'spare_part_id');
    }
}
