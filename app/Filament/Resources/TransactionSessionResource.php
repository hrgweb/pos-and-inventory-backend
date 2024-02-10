<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\TransactionSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransactionSessionResource\Pages;
use App\Filament\Resources\TransactionSessionResource\RelationManagers;
use Inventory\Order\Enums\OrderStatus;

class TransactionSessionResource extends Resource
{
    protected static ?string $model = TransactionSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Session No';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('session_no')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('grand_total')
                    ->numeric(),
                Forms\Components\TextInput::make('amount')
                    ->numeric(),
                Forms\Components\TextInput::make('change')
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->maxLength(255)
                    ->default('pending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('session_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grand_total')
                    ->numeric(
                        decimalPlaces: 2,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    )
                    ->default(0)
                    ->sortable()
                    ->label('Total'),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric(
                        decimalPlaces: 2,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    )
                    ->default(0)
                    ->sortable(),
                Tables\Columns\TextColumn::make('change')
                    ->numeric(
                        decimalPlaces: 2,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    )
                    ->default(0)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->color(fn (Model $model): string => match ($model->status) {
                        OrderStatus::PENDING->value => 'warning',
                        OrderStatus::VOID->value => 'danger',
                        OrderStatus::COMPLETED->value => 'success'
                    })
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
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
            'index' => Pages\ListTransactionSessions::route('/'),
            'create' => Pages\CreateTransactionSession::route('/create'),
            'view' => Pages\ViewTransactionSession::route('/{record}'),
            // 'edit' => Pages\EditTransactionSession::route('/{record}/edit'),
        ];
    }
}
