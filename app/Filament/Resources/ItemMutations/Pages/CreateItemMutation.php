<?php

namespace App\Filament\Resources\ItemMutations\Pages;

use App\Enums\MutationType;
use App\Filament\Resources\ItemMutations\ItemMutationResource;
use App\Models\Item;
use App\Services\ItemMutationService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CreateItemMutation extends CreateRecord
{
    protected static string $resource = ItemMutationResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = app(ItemMutationService::class);
        $item = Item::findOrFail($data['item_id']);
        
        $type = MutationType::from($data['mutation_type']);
        $mutationDate = Carbon::parse($data['mutation_date']);
        
        return $service->mutate(
            $item,
            $type,
            $data['to_room_id'] ?? null,
            $data['to_employee_id'] ?? null,
            $mutationDate,
            $data['description'] ?? null,
            auth()->user()
        );
    }
}
