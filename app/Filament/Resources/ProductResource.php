<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('supplier_id')
                    ->native(false)
                    ->required()
                    ->relationship(name: 'supplier', titleAttribute: 'name'),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('cost_price')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('selling_price')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('stock_qty')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('reorder_level')
                    ->numeric(),
                Forms\Components\TextInput::make('reorder_level_danger')
                    ->numeric(),
                Forms\Components\TextInput::make('barcode')
                    ->maxLength(255),
                // Forms\Components\Toggle::make('is_available')
                //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Product Name'),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->searchable()
                    ->label('Supplier Name'),
                Tables\Columns\TextColumn::make('cost_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('selling_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_qty')
                    ->numeric()
                    ->sortable()
                    ->color(function (Model $model): string {
                        if ($model->stock_qty <= $model->reorder_level_danger) {
                            return 'danger';
                        }
                        if ($model->stock_qty <= $model->reorder_level) {
                            return 'warning';
                        }
                        return 'success';
                    })
                    ->badge(),
                Tables\Columns\TextColumn::make('reorder_level')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('barcode')
                    ->searchable(),
                // Tables\Columns\IconColumn::make('is_available')
                //     ->boolean(),
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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
