<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{

    protected $appends = [
        'name',
        'type',
    ];
    
    public const TYPES = [
        1 => 'int',
        2 => 'string',
        3 => 'bool',
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
