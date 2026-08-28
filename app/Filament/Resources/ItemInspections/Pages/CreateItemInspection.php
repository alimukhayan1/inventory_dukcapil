<?php

namespace App\Filament\Resources\ItemInspections\Pages;

use App\Enums\ItemCondition;
use App\Filament\Resources\ItemInspections\ItemInspectionResource;
use App\Models\Item;
use App\Services\ItemInspectionService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CreateItemInspection extends CreateRecord
{
    protected static string $resource = ItemInspectionResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = app(ItemInspectionService::class);
        $item = Item::findOrFail($data['item_id']);
        
        $inspectionDate = Carbon::parse($data['inspection_date']);
        $isFound = $data['is_found'];
        
        // If not found, condition will be set to HILANG by the service
        $condition = isset($data['condition']) 
            ? ItemCondition::from($data['condition']) 
            : ItemCondition::HILANG;
        
        return $service->inspect(
            $item,
            $inspectionDate,
            $isFound,
            $condition,
            $data['notes'] ?? null,
            auth()->user()
        );
    }
}
