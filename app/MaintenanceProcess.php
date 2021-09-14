<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaintenanceProcess extends Model
{
    public function details(): HasMany
    {
        return $this->hasMany('App\MaintenanceDetail');
    }
}
