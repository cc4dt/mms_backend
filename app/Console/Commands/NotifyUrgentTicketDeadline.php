<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use App\Ticket;

class NotifyUrgentTicketDeadline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:urgent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $tickets = Ticket::whereHas('status',  function($q) {
            $q->where("key", "!=", "closed")->where("key", "!=", "cancelled");
        })->whereHas('priority',  function($q) {
            $q->where("key", "=", "urgent");
        })->get();

        foreach ($tickets as $ticket) {
            if($ticket->deadline) {
                $totalDuration = Carbon::now()->diffInSeconds($ticket->deadline);
                $leftTime = floor($totalDuration / 3600) . gmdate(":i", $totalDuration % 3600);

                try {
                    Notification::send(User::supervisors()->merge(User::clients()), new TicketDeadline($ticket, $leftTime));
                } catch (\Throwable $th) {
                    //throw $
                }
            }
        }

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
