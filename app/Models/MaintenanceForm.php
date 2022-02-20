<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceForm extends Model
{
    use HasFactory;

    public $additional_attributes = ['full_name'];
    
    public function getFullNameAttribute()
    {
        return "{$this->category->name} {$this->equipment->name}";
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
    
    public function procedures()
    {
        return $this->belongsToMany(MaintenanceProcedure::class, 'form_procedure', 'form_id', 'procedure_id');
    }
    
}
