<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HseDetail extends Model
{
    protected $fillable = [
        'process_id',
        'spare_sub_part_id',
        'procedure_id',
        'option_id',
        'value',
    ];

    protected $appends = [
        'name',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(HseProcess::class, 'process_id', 'hse_processes');
    }

    public function spare_sub_part(): BelongsTo
    {
        return $this->belongsTo(SpareSubPart::class);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
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