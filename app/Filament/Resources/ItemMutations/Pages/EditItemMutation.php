<?php

namespace App\Filament\Resources\ItemMutations\Pages;

use App\Filament\Resources\ItemMutations\ItemMutationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditItemMutation extends EditRecord
{
    protected static string $resource = ItemMutationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
