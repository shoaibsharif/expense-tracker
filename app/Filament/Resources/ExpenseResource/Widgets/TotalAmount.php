<?php

namespace App\Filament\Resources\ExpenseResource\Widgets;

use Akaunting\Money\Money;
use App\Models\Expense;
use Filament\Widgets\Widget;

class TotalAmount extends Widget
{
    protected static string $view = "filament.resources.expense-resource.widgets.total-amount";

    public string $totalExpenseAmount;

    public function mount()
    {
        $this->totalExpenseAmount = Money::USD(
            Expense::query()->sum("amount"),
            true
        );
    }
}
