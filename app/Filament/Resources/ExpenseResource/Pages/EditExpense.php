<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use App\Filament\Resources\ExpenseResource;
use App\Models\Expense;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EditExpense extends EditRecord
{
    protected static string $resource = ExpenseResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if (
            $record->attachment &&
            $record->attachment !== $data["attachment"]
        ) {
            Storage::disk("s3")->delete($record->attachment);
        }

        $record->update($data);

        return $record;
    }
    protected function getActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
