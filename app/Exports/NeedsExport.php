<?php

namespace App\Exports;

use App\Models\Detail;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


use Carbon\Carbon;

class NeedsExport implements FromCollection, WithMapping, WithHeadings, WithTitle, ShouldAutoSize
{

    private $details;
    private $procedures;

    protected $form;
    protected $from;
    protected $to;
    protected $station;

    public function __construct($form, $from = null, $to = null, $station = null)
    {
        $this->form = $form;
        $this->from = $from;
        $this->to = $to;
        $this->station = $station;

        
        $this->details = Detail::whereHas('option',  function ($q) {
            $q->replaces();
        })
            ->whereHas('process', function ($q) {
                $q->whereHas('maintenance', function ($q) {
                    $q->where('category_id', $this->form->category_id);
                    if ($this->from)
                        $q->where('created_at', '>=', $this->from);
                    if ($this->to)
                        $q->where('created_at', '<=', $this->to);
                    if ($this->station)
                        $q->where('station_id', $this->station->id);
                });
            })
            ->with('process')
            ->get();

        $this->procedures = $this->form->procedures->filter(function($i) {
            return $this->details->where('procedure_id', $i->id)->count();
        });
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

        $query = $this->form->equipment->equipment();

        if ($this->station)
            $query->where('station_id', $this->station->id);

        return $query->get();
    }

    public function map($equipment): array
    {
        $details = $this->details->filter(function ($item) use ($equipment) {
            return $item->process->master_equipment_id == $equipment->id;
        });
        // many->pluck('name')->implode(', '),
        return [
            $equipment->serial,
            ...$this->procedures->map(function ($i) use ($details) {
                return $details->where('procedure_id', $i->id)->count();
            }),
        ];
    }

    public function headings(): array
    {
        return [
            'Serial',
            ...$this->procedures->map(function ($i) {
                return $i->name;
            })
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Needs: ' . $this->form->full_name;
    }
}
