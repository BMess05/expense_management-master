<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExpenseExport implements FromView
{
     protected $expenses;

    function __construct($expenses) {
        $this->expenses = $expenses;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view() : View
    {
        
        return view('expense.expense.exportList', [
            'expenses' => $this->expenses
        ]);
        
    }


}

