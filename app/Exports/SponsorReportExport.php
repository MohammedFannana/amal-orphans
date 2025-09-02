<?php

namespace App\Exports;

use App\Models\Sponsor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class SponsorReportExport implements FromCollection, WithHeadings
{

    public function collection()
    {
        return Sponsor::select('name' , 'email' , 'phone' ,'country' ,'address')->get();
    }

    public function headings(): array
    {
        return ['اسم الكافل', 'البريد الالكتروني' , 'رقم الهاتف' , 'الدولة' , 'العنوان'];
    }
}
