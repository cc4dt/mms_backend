<?php

namespace App\Exports;

use App\Models\Maintenance;
use App\Models\Process;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


use Carbon\Carbon;

class MaintenancesExport implements FromCollection, WithMapping, WithHeadings, WithTitle, ShouldAutoSize
{
    
    protected $form;
    protected $from;
    protected $to;
    protected $station;

    public function __construct($form, $from = null, $to = null, $station = null) {
        $this->form = $form;
        $this->from = $from;
        $this->to = $to;
        $this->station = $station;
    }
    
    // public function drawings()
    // {
    //     $drawing = new Drawing();
    //     $drawing->setName('Logo');
    //     $drawing->setDescription('This is my logo');
    //     // $drawing->setPath(public_path('/img/logo.jpg'));
    //     $drawing->setHeight(90);
    //     $drawing->setCoordinates('B3');

    //     return $drawing;
    // }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Process::where('equipment_id', $this->form->equipment_id)
            ->whereHas('maintenance', function($q) {
                $q->where('category_id', $this->form->category_id);
            });
        if($this->from)
            $query->where('created_at', '>=', $this->from);
        if($this->to)
            $query->where('created_at', '<=', $this->to);
        if($this->station)
            $query->whereHas('maintenance', function($q) {
                $q->where('station_id', $this->station->id);
            });
        return $query->get();
    }

    public function map($process) : array {
        
        // many->pluck('name')->implode(', '),
        $details = $process->details;
        return [
            $process->master_equipment ? $process->master_equipment->serial : '',
            $process->maintenance->created_by->name,
            Carbon::parse($process->maintenance->date)->toFormattedDateString(),
            ...$this->form->procedures->map(function($i) use($details) {
                $value = $details->where('procedure_id', $i->id)->first();
                return $value->option ? $value->option->name : $value->value;
            }),
        ];
    }
 
    public function headings() : array {
        return [
           'Serial',
           'Created By',
           'Date',
           ...$this->form->procedures->map(function($i) {return $i->name;})
        ] ;
    }
    
    /**
     * @return string
     */
    public function title(): string
    {
        return $this->form->full_name;
    }
}
