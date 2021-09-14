<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterEquipment extends Model
{
    public function details(): HasMany
    {
        return $this->hasMany('App\MasterDetail');
    }
}
