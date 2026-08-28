<?php

namespace App\Filament\Resources\ItemInspections\Pages;

use App\Filament\Resources\ItemInspections\ItemInspectionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditItemInspection extends EditRecord
{
    protected static string $resource = ItemInspectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
