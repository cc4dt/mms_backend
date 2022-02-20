<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'station_id',
        'date',
        'created_by_id',
        'updated_by_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class);
    }

    public function processes()
    {
        return $this->hasMany(Process::class);
    }
}
