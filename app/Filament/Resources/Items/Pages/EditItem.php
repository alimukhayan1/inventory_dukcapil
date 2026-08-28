<?php

namespace App\Filament\Resources\Items\Pages;

use App\Filament\Resources\Items\ItemResource;
use App\Services\ActivityLogService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItem extends EditRecord
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(function () {
                    app(ActivityLogService::class)->log(
                        auth()->user(),
                        'DELETE_ITEM',
                        $this->record,
                        "Menghapus barang: {$this->record->inventory_code} - {$this->record->name}"
                    );
                }),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make()
                ->after(function () {
                    app(ActivityLogService::class)->log(
                        auth()->user(),
                        'RESTORE_ITEM',
                        $this->record,
                        "Memulihkan barang: {$this->record->inventory_code} - {$this->record->name}"
                    );
                }),
        ];
    }

    protected function afterSave(): void
    {
        app(ActivityLogService::class)->log(
            auth()->user(),
            'UPDATE_ITEM',
            $this->record,
            "Mengubah data barang: {$this->record->inventory_code} - {$this->record->name}"
        );
    }
}
