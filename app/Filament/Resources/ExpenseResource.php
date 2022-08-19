<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = "heroicon-o-collection";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("name")->required(),
            Forms\Components\TextInput::make("amount")
                ->numeric()
                ->required()
                ->mask(
                    fn(Forms\Components\TextInput\Mask $mask) => $mask->money()
                ),
            Forms\Components\DatePicker::make("expense_date")->displayFormat(
                "d F Y"
            ),
            Forms\Components\MultiSelect::make("tags")->relationship(
                "tags",
                "name"
            ),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("expense_date")
                    ->date("d F Y")
                    ->sortable(),
                Tables\Columns\TagsColumn::make("tags.name"),
                Tables\Columns\TextColumn::make("amount")
                    ->money("usd", true)
                    ->alignRight(),
            ])
            ->filters([
                Tables\Filters\MultiSelectFilter::make("tags")->relationship(
                    "tags",
                    "name"
                ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListExpenses::route("/"),
            "create" => Pages\CreateExpense::route("/create"),
            "edit" => Pages\EditExpense::route("/{record}/edit"),
        ];
    }
    public static function getWidgets(): array
    {
        return [ExpenseResource\Widgets\TotalAmount::class];
    }
}
