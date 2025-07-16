<?php

namespace App\Imports;

use App\Models\Post;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validate dealer_id exists
        $dealer = User::find($row['dealer_id']);
        if (!$dealer) {
            return null; // Skip row if dealer_id is invalid
        }

        // Validate required fields
        $validator = Validator::make($row, [
            'title' => 'required|string|max:255',
            'condition' => 'required|string',
            'assembly' => 'required|string',
            'company_connection' => 'required|string',
            'currency' => 'required|string',
            'price' => 'required|string',
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|string',
            'milleage' => 'required|string',
            'doors' => 'required|string',
            'fuel' => 'required|string',
            'seating_capacity' => 'required|string',
            'engine_capacity' => 'required|string',
            'transmission' => 'required|string',
            'drive_type' => 'required|string',
            'exterior_color' => 'required|string',
            'status' => ['required', Rule::in(['In Review', 'Active', 'Rejected'])],
        ]);

        if ($validator->fails()) {
            return null; // Skip invalid rows
        }

        // Map status to integer
        $status = $row['status'] === 'In Review' ? 0 : ($row['status'] === 'Active' ? 1 : 2);

        return new Post([
            'dealer_id' => $row['dealer_id'],
            'title' => $row['title'],
            'condition' => $row['condition'],
            'assembly' => $row['assembly'],
            'company_conection' => $row['company_connection'],
            'currency' => $row['currency'],
            'price' => $row['price'],
            'negotiated_price' => $row['negotiated_price'] ?? null,
            'make' => $row['make'],
            'model' => $row['model'],
            'year' => $row['year'],
            'milleage' => $row['milleage'],
            'body_type' => $row['body_type'] ?? null,
            'doors' => $row['doors'],
            'fuel' => $row['fuel'],
            'seating_capacity' => $row['seating_capacity'],
            'engine_capacity' => $row['engine_capacity'],
            'transmission' => $row['transmission'],
            'drive_type' => $row['drive_type'],
            'exterior_color' => $row['exterior_color'],
            'dealer_comment' => $row['dealer_comment'] ?? null,
            'status' => $status,
        ]);
    }
}