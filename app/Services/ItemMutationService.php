<?php

namespace App\Services;

use App\Enums\MutationType;
use App\Models\Item;
use App\Models\ItemMutation;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\DB;

class ItemMutationService
{
    public function __construct(
        protected ActivityLogService $activityLogService
    ) {}

    public function mutate(
        Item $item,
        MutationType $type,
        ?int $toRoomId,
        ?int $toEmployeeId,
        CarbonInterface $mutationDate,
        ?string $description,
        User $user
    ): ItemMutation {
        return DB::transaction(function () use ($item, $type, $toRoomId, $toEmployeeId, $mutationDate, $description, $user) {
            // Lock item for update to prevent concurrent modifications
            $item = Item::query()->lockForUpdate()->findOrFail($item->id);

            // Capture current state
            $fromRoomId = $item->room_id;
            $fromEmployeeId = $item->employee_id;

            // Create mutation history record
            $mutation = ItemMutation::create([
                'item_id' => $item->id,
                'mutation_type' => $type,
                'from_room_id' => $fromRoomId,
                'to_room_id' => $toRoomId,
                'from_employee_id' => $fromEmployeeId,
                'to_employee_id' => $toEmployeeId,
                'mutation_date' => $mutationDate,
                'description' => $description,
                'created_by' => $user->id,
            ]);

            // Update item current state based on mutation type
            $updateData = [];

            if (in_array($type, [MutationType::ROOM, MutationType::ROOM_AND_EMPLOYEE])) {
                $updateData['room_id'] = $toRoomId;
            }

            if (in_array($type, [MutationType::RESPONSIBLE_EMPLOYEE, MutationType::ROOM_AND_EMPLOYEE])) {
                $updateData['employee_id'] = $toEmployeeId;
            }

            if (!empty($updateData)) {
                $item->update($updateData);
            }

            // Create activity log within the same transaction
            $this->activityLogService->log(
                $user,
                'CREATE_MUTATION',
                $item,
                "Mutasi barang {$item->inventory_code}: {$type->label()}"
            );

            return $mutation;
        });
    }
}
