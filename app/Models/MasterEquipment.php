<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MasterEquipment extends Model
{
    protected $fillable = [
        'equipment_id',
        'station_id',
        'serial',
    ];

    protected $appends = [
        'qrcode',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }
    
    public function processes(): HasMany
    {
        return $this->hasMany(MaintenanceProcess::class, 'master_equipment_id');
    }
    
    public function details(): HasMany
    {
        return $this->hasMany(MasterDetail::class, 'equipment_id');
    }

    public function getQrcodeAttribute($value)
    {
        if($this->serial)
            return QrCode::size(160)->generate($this->serial);
    }
}
