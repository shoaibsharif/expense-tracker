<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = "heroicon-o-collection";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("name")
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make("email")
                ->email()
                ->required()
                ->maxLength(255),
            Forms\Components\DateTimePicker::make("email_verified_at"),
            Forms\Components\MultiSelect::make("roles")->relationship(
                "roles",
                "name"
            ),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name"),
                Tables\Columns\TextColumn::make("email"),
                Tables\Columns\TextColumn::make(
                    "email_verified_at"
                )->dateTime(),
                Tables\Columns\TextColumn::make("created_at")->dateTime(),
                Tables\Columns\TextColumn::make("updated_at")->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(
                        fn(User $user): bool => auth()
                            ->user()
                            ->can("delete", $user->id)
                    )

                    ->requiresConfirmation(),
                Tables\Actions\Action::make("Reset Password")
                    ->action(function (User $record) {
                        $status = Password::sendResetLink([
                            "email" => $record->email,
                        ]);

                        if ($status === Password::RESET_LINK_SENT) {
                            Notification::make()
                                ->title("Password reset link sent")
                                ->icon("heroicon-o-check-circle")
                                ->iconColor("success")
                                ->send();
                        }
                    })
                    ->requiresConfirmation(),
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
            "index" => Pages\ListUsers::route("/"),
            "create" => Pages\CreateUser::route("/create"),
            "edit" => Pages\EditUser::route("/{record}/edit"),
        ];
    }
}
