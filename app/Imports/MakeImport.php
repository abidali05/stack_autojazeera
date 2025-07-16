<?php

namespace App\Imports;

use App\Models\MakeCompany;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class MakeImport implements ToModel, WithHeadingRow
{
    /**
     * Map Excel row to MakeCompany model.
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

        return new MakeCompany([
            'name' => $row['name'],
            'icon' => $row['icon'] ?? null,
            'status' => $row['status'] === 'Inactive' ? 0 : 1,
        ]);
    }
}