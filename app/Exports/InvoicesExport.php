<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class InvoicesExport implements FromView, WithTitle
{
    public function view(): View
    {
        return view('exports.invoices', [
            'invoices' => User::all()
        ]);
    }
    
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Month ' . $this->month;
    }
}