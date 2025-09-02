<?php

namespace App\Exports;

use App\Models\Sponsorship;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class SponsorshipReportExport implements FromCollection, WithHeadings
{

    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function collection()
    {
        return Sponsorship::when($this->status, function ($query) {
                $query->where('status', $this->status);
        })
        ->select('orphan_id' , 'sponsor_id' , 'sponsorship_date' ,'duration' ,'bail_amount' , 'total' ,'status')
        ->get()
        ->map(function ($item) {
            return [
                'orphan'  => $item->orphan ? $item->orphan->name : ' ',
                'sponsor' => $item->sponsor? $item->sponsor->name : ' ',
                'sponsorship_date'    => $item->sponsorship_date,
                'duration'   => $item->duration,
                'bail_amount'   => $item->bail_amount,
                'total' => $item->total,
                'status' => $item->status,

            ];
        });

    }

    public function headings(): array
    {
        return ['اسم اليتيم', 'اسم الكافل' ,'تاريخ الكفالة' , 'مدة الكفالة' , 'ميلغ الكفالة الشهري' , 'المبلغ الاجمالي' , 'حالة الكفالة'];
    }
}
