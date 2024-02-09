<?php

namespace App\Filament\Resources\TransactionSessionResource\Pages;

use App\Filament\Resources\TransactionSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionSession extends EditRecord
{
    protected static string $resource = TransactionSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
