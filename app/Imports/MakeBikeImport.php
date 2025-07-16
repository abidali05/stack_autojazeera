<?php

namespace App\Imports;

use App\Models\Bike\BikeMake;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class MakeBikeImport implements ToModel, WithHeadingRow
{
    /**
     * Map Excel row to BikeMake model.
     */
    public function model(array $row)
    {
        // Validate the row
        $validator = Validator::make($row, [
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'status' => 'required|in:Inactive,Active',
        ]);

        if ($validator->fails()) {
            return null; // Skip invalid rows
        }

        return new BikeMake([
            'name' => $row['name'],
            'icon' => $row['icon'] ?? null,
            'status' => $row['status'] === 'Inactive' ? 0 : 1,
        ]);
    }
}