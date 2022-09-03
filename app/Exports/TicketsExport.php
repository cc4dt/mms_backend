<?php

namespace App\Exports;

use App\Models\Ticket;
use App\Models\TicketType;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;



use Carbon\Carbon;

class TicketsExport implements FromCollection, WithMapping, WithHeadings, WithTitle, ShouldAutoSize
{

    private $type;
    protected $from;
    protected $to;
    protected $station;

    public function __construct($type, $from = null, $to = null, $station = null)
    {
        $this->type = $type;
        $this->from = $from;
        $this->to = $to;
        $this->station = $station;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = $this->type->tickets();
        if ($this->from)
            $query->where('created_at', '>=', $this->from);
        if ($this->to)
            $query->where('created_at', '<=', $this->to);
        if ($this->station)
            $query->where('station_id', $this->station->id);
        return $query->get();
    }
    public function map($ticket): array
    {

        // many->pluck('name')->implode(', '),
        return [
            $ticket->number,
            $ticket->equipment->name,
            $ticket->breakdown->name,
            $ticket->openline ? $ticket->openline->created_by->name : '',
            $ticket->openline ? Carbon::parse($ticket->openline->timestamp)->toFormattedDateString() : '',
            $ticket->openline ? $ticket->openline->description : '',
            $ticket->actions,
            $ticket->timeline->status->name,
            $ticket->closeline ? $ticket->closeline->created_by->name : '',
            $ticket->closeline ? Carbon::parse($ticket->closeline->timestamp)->toFormattedDateString() : '',
            $ticket->closeline ? $ticket->closeline->description : '',
            $ticket->led_time,
            $ticket->in_sla ? 'IN SLA' : 'OUT SLA',
            $ticket->sla,
        ];
    }

    public function headings(): array
    {
        return [
            'No.',
            'Equipment',
            'Breakdown',
            'Opened By',
            'Opened At',
            'Opened Note',
            'Action Done',
            'Status',
            'Closed By',
            'Closed At',
            'Closed Note',
            'Led Time',
            'SLA',
            'SLA Range',
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Tickets: ' . $this->type->name;
    }
}
