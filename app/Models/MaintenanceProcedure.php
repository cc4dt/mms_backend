<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MaintenanceProcedure extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'spare_part_id',
        'input_type_id',
        'type_id',
    ];

    protected $appends = [
        'name',
        'type',
        'price',
    ];
    
    public const TYPES = [
        1 => 'mainten',
        2 => 'replace',
        3 => 'clean',
        4 => 'other',
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

    public function scopeReplaces($query)
    {
        $typeId = array_search('replace', self::TYPES);
        return $query->where('type_id', $typeId);
    }

    public function spare_part(): BelongsTo
    {
        return $this->belongsTo(SparePart::class);
    }

    
    public function input_type(): BelongsTo
    {
        return $this->belongsTo(Enum::class);
    }

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class, 'option_procedure', 'procedure_id', 'option_id');
    }

    public function getPriceAttribute($value)
    {
        return $this->spare_part->price ?? 0;
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

    static public function getTypeId($value) {
        $typeID = array_search($value, self::TYPES);
        if($typeID) {
            return $typeID;
        } else { 
            return null;
        }
    }

    public function setTypeAttribute($value)
    {
        $typeID = array_search($value, self::TYPES);
        if ($typeID) {
            $this->attributes['type_id'] = $typeID;
        }
    }
}
