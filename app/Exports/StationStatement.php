<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use App\Models\Equipment;
use App\Models\TicketType;
use App\Models\MaintenanceForm;

// use Illuminate\Support\Carbon;

class StationStatement implements WithMultipleSheets
{
    use Exportable;

    protected $station;
    protected $from;
    protected $to;
    
    public function __construct($station, $from = null, $to = null)
    {
        $this->station = $station;
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        foreach (TicketType::all() as $item) {
            $sheets[] = new TicketsExport($item, $this->from, $this->to, $this->station);
        }

        foreach (MaintenanceForm::all() as $item) {
            $sheets[] = new NeedsExport($item, $this->from, $this->to, $this->station);
        }

        foreach (MaintenanceForm::all() as $item) {
            $sheets[] = new MaintenancesExport($item, $this->from, $this->to, $this->station);
        }
        
        return $sheets;
    }
}