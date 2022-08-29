<?php

namespace App\Listeners;

use App\Events\ExpenseDeletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class ExpenseDeletingListener implements ShouldQueue
{
    public function __construct()
    {
    }

    public function handle(ExpenseDeletedEvent $event): void
    {
        Storage::disk("s3")->delete($event->expense->attachment);
    }
}
