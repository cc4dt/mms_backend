<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpareSubPart extends Model
{
    protected $fillable = [
        "name_en",
        "name_ar",
        "spare_part_id",
    ];
    
    protected $appends = [
        'name',
        'price',
    ];

    public function getNameAttribute($value)
    {
        return $this->{'name_' . app()->getlocale()};
    }

    public function setNameAttribute($value)
    {
        $this->{'name_' . app()->getlocale()} = $value;
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(SparePart::class, 'spare_part_id');
    }

    public function getPriceAttribute($value)
    {
        return $this->price ?? $this->part->price;
    }
}
