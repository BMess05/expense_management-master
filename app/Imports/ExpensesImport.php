<?php

namespace App\Imports;
use App\Models\Expense;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;


class ExpensesImport implements ToCollection,WithHeadingRow
{
     /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

     public $rows;
     public function collection(Collection $collection)
    {
        $this->rows = $collection;
    }
}
