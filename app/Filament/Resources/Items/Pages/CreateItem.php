<?php

namespace App\Filament\Resources\Items\Pages;

use App\Filament\Resources\Items\ItemResource;
use App\Services\ActivityLogService;
use Filament\Resources\Pages\CreateRecord;

class CreateItem extends CreateRecord
{
    protected static string $resource = ItemResource::class;

    protected function afterCreate(): void
    {
        app(ActivityLogService::class)->log(
            auth()->user(),
            'CREATE_ITEM',
            $this->record,
            "Menambahkan barang baru: {$this->record->inventory_code} - {$this->record->name}"
        );
    }
}
