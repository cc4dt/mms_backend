<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_id',
        'equipment_id',
        'master_equipment_id',
        'description',
    ];

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function master_equipment()
    {
        return $this->belongsTo(MasterEquipment::class);
    }

    public function details()
    {
        return $this->hasMany(Detail::class);
    }
}
