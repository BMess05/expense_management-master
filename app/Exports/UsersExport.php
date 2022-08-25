<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class UsersExport implements FromCollection, WithHeadings, WithEvents, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select(['id','name','email','personal_phone','aadhar_no','pan_no','date_of_joining','ctc','department','position',])->get();
    }

    public function map($users): array
    {
        return [
            $users->name,
            $users->email,
            $users->personal_phone,
            $users->aadhar_no,
            $users->pan_no,
            date('d-m-Y',strtotime($users->date_of_joining)),
            $users->ctc,
            $users->department_data->name?? " ",
            $users->position_data->name ?? " ",
            $users->getRoleNames()[0] ?? " ",
         ]; 
     }

    public function headings() :array
    {
        return [
            'Name',
            'Official Email ID',
            'Phone Number',
            'Aadhar Number',
            'PAN Number',
            'Date of Joining',
            'CTC',
            'Department',
            'Position',
            'Role',
            
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
   
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(30);
                foreach(range('A','Z') as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
                foreach(range('1','1000') as $column) {
                    $event->sheet->getDelegate()->getStyle($column)
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                }
            },
        ];
    }
}
