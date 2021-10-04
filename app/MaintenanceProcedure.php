<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceProcedure extends Model
{

    protected $appends = [
        'name',
        'type',
    ];
    
    public const TYPES = [
        1 => 'int',
        2 => 'string',
        3 => 'bool',
        4 => 'text',
    ];

    static public function constList($list)
    {
        $items = array();
        foreach ($list as $key => $value) {
            $items[] = (object) [
                "key" => $value,
                "value" => __('constants.'.$value)
            ];
        }
        return $items;
    }

    static public function types()
    {
        return Attribute::constList(Attribute::TYPES);
    }

    
    public function spare_part(): BelongsTo
    {
        return $this->belongsTo('App\SparePart');
    }

    public function getNameAttribute($value)
    {
        return $this->{'name_' . app()->getlocale()};
    }

    public function setNameAttribute($value)
    {
        $this->{'name_' . app()->getlocale()} = $value;
    }
    
    public function getTypeAttribute()
    {
        if ($this->attributes['type_id'])
            return (object) [
                "key" => self::TYPES[$this->attributes['type_id']],
                "value" => __('constants.'.self::TYPES[$this->attributes['type_id']]),
            ];
    }

    public function setTypeAttribute($value)
    {
        $typeID = array_search($value, self::TYPES);
        if ($typeID) {
            $this->attributes['type_id'] = $typeID;
        }
    }
}
