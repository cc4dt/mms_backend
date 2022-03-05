<?php

namespace App\Exports;

use App\Models\Maintenance;
use App\Models\Category;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


use Carbon\Carbon;

class MaintenancesExport implements FromCollection, WithMapping, WithHeadings
{
    
    private $slug;

    public function __construct($slug) {
        $this->slug = $slug;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $category = Category::where('slug', '=', $this->slug)->first();
        return $category->maintenances;
    } 
    public function map($maintenance) : array {
        
        // many->pluck('name')->implode(', '),
        return [
            $maintenance->id,
            $maintenance->station->name,
            $maintenance->created_by->name,
            Carbon::parse($maintenance->date)->toFormattedDateString()
        ] ;
 
 
    }
 
    public function headings() : array {
        return [
           '#',
           'Station',
           'Created By',
           'Date',
        ] ;
    }
}
