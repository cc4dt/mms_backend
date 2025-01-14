<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{
    protected $appends = [
        'name',
    ];

    public function parts(): BelongsToMany
    {   
        return $this->belongsToMany(Part::class);
    }

    public function pm_procedures(): BelongsToMany
    {   
        return $this->belongsToMany(MaintenanceProcedure::class, 'pm_procedure', 'equipment_id', 'procedure_id');
    }

    public function breakdowns(): HasMany
    {
        return $this->hasMany(Breakdown::class);
    }

    public function equipment(): HasMany
    {
        return $this->hasMany(MasterEquipment::class, 'equipment_id');
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function forms()
    {
        return $this->hasMany(MaintenanceForm::class);
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