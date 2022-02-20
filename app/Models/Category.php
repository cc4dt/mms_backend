<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use TCG\Voyager\Traits\Translatable;

class Category extends Model
{
    use HasFactory;
    use Translatable;
    
    protected $translatable = ['name'];

    public function equipment(): BelongsToMany
    {   
        return $this->belongsToMany(Equipment::class, 'maintenance_forms');
    }

    public function forms()
    {
        return $this->hasMany(MaintenanceForm::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }
}
