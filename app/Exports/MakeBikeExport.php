<?php

namespace App\Exports;

use App\Models\Bike\BikeMake;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MakeBikeExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return BikeMake::all();
    }

    /**
     * Define the headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Icon',
            'Status',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Map each row of data.
     */
    public function map($bikeMake): array
    {
        return [
            $bikeMake->id,
            $bikeMake->name,
            $bikeMake->icon ?? 'N/A',
            $bikeMake->status == 0 ? 'Inactive' : 'Active',
            $bikeMake->created_at ? $bikeMake->created_at->format('d M Y') : 'N/A',
            $bikeMake->updated_at ? $bikeMake->updated_at->format('d M Y') : 'N/A',
        ];
    }
}
