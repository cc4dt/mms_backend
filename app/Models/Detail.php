<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'process_id',
        'spare_part_id',
        'procedure_id',
        'option_id',
        'value',
    ];

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function spare_part()
    {
        return $this->belongsTo(SpareSubPart::class);
    }

    public function procedure()
    {
        return $this->belongsTo(MaintenanceProcedure::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
