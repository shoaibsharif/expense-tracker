<?php

namespace App\Filament\Resources\ExpenseResource\Widgets;

use Akaunting\Money\Money;
use App\Models\Expense;
use Filament\Widgets\Widget;

class TotalAmount extends Widget
{
    protected static string $view = "filament.resources.expense-resource.widgets.total-amount";

    public string $totalExpenseAmount;

    protected $listeners = ["updateTotalAmount" => "update"];

    public function update($tags)
    {
        $tags = collect($tags)
            ->pluck("values")
            ->flatten()
            ->map(fn($item) => (int) $item);

        $this->totalExpenseAmount = \Cache::remember(
            "expenseTotalAmount" . $tags->escapeWhenCastingToString(),
            5,
            function () use ($tags) {
                $expenseAmount = Expense::query();
                if (count($tags) > 0) {
                    $expenseAmount = $expenseAmount->whereHas(
                        "tags",
                        fn($query) => $query->whereIn("id", $tags->toArray())
                    );
                }
                return Money::USD($expenseAmount->sum("amount"), true);
            }
        );
    }
    public function boot()
    {
        $tags = request()->get("tableFilters")["tags"] ?? [];
        if (count($tags) > 0) {
            $this->update($tags);
        } else {
            $this->totalExpenseAmount = Money::USD(
                Expense::query()->sum("amount"),
                true
            );
        }
    }
}
