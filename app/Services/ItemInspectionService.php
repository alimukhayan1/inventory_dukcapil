<?php

namespace App\Services;

use App\Enums\ItemCondition;
use App\Models\Item;
use App\Models\ItemInspection;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\DB;

class ItemInspectionService
{
    public function __construct(
        protected ActivityLogService $activityLogService
    ) {}

    public function inspect(
        Item $item,
        CarbonInterface $inspectionDate,
        bool $isFound,
        ItemCondition $condition,
        ?string $notes,
        User $user
    ): ItemInspection {
        return DB::transaction(function () use ($item, $inspectionDate, $isFound, $condition, $notes, $user) {
            // Lock item for update
            $item = Item::query()->lockForUpdate()->findOrFail($item->id);

            // Determine the condition: if not found, always set to 'hilang'
            $actualCondition = $isFound ? $condition : ItemCondition::HILANG;

            // Create inspection history record
            $inspection = ItemInspection::create([
                'item_id' => $item->id,
                'inspection_date' => $inspectionDate,
                'is_found' => $isFound,
                'condition' => $actualCondition,
                'notes' => $notes,
                'inspected_by' => $user->id,
            ]);

            // Update item condition
            $item->update([
                'condition' => $actualCondition,
            ]);

            // Create activity log within the same transaction
            $this->activityLogService->log(
                $user,
                'CREATE_INSPECTION',
                $item,
                "Pemeriksaan barang {$item->inventory_code}: " .
                ($isFound ? "Ditemukan - {$actualCondition->label()}" : 'Tidak ditemukan - Hilang')
            );

            return $inspection;
        });
    }
}
