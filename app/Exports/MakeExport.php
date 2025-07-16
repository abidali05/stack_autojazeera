<?php

namespace App\Exports;

use App\Models\MakeCompany;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MakeExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return MakeCompany::all();
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
    public function map($make): array
    {
        return [
            $make->id,
            $make->name,
            $make->icon ?? 'N/A',
            $make->status == 0 ? 'Inactive' : 'Active',
            $make->created_at ? $make->created_at->format('d M Y') : 'N/A',
            $make->updated_at ? $make->updated_at->format('d M Y') : 'N/A',
        ];
    }
}