<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\userBankAccount;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class UserBankDetailsExport implements FromCollection, WithHeadings, WithEvents, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return userBankAccount::select("*")
        ->orderBy('created_at', 'desc')
        ->get()
        ->unique('employee_id');
    }

    public function map($bankDetails): array
    {
        return [
            $bankDetails->user->name ?? '',
            $bankDetails->ac_holder,
            $bankDetails->account_no,
            $bankDetails->bank_name,
            $bankDetails->ifsc_code,
         ]; 
     }

     public function headings() :array
     {
         return [
             'Employee Name',
             'Account Holder',
             'Account Number',
             'Bank Name',
             'IFSC Code',
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