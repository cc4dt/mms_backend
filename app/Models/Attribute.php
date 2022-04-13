<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{

    protected $appends = [
        'type',
    ];
    
    public const TYPES = [
        1 => 'radio',
        2 => 'dropdown',
        3 => 'string',
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

    public function options()
    {
        return $this->belongsToMany(Option::class, 'attribute_option', 'attribute_id', 'option_id');
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
