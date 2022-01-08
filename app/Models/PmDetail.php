<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PmDetail extends Model
{
    protected $fillable = [
        'process_id',
        'spare_part_id',
        'procedure_id',
        'option_id',
        'value',
    ];
    
    use HasFactory;

    public function process(): BelongsTo
    {
        return $this->belongsTo(PmProcess::class, 'process_id', 'pm_processes');
    }

    public function spare_part(): BelongsTo
    {
        return $this->belongsTo(SpareSubPart::class);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
