<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PostsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Post::with('dealer')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Dealer ID',
            'Dealer Name',
            'Dealer Email',
            'Title',
            'Condition',
            'Assembly',
            'Company Connection',
            'Currency',
            'Price',
            'Negotiated Price',
            'Make',
            'Model',
            'Year',
            'Mileage',
            'Body Type',
            'Doors',
            'Fuel',
            'Seating Capacity',
            'Engine Capacity',
            'Transmission',
            'Drive Type',
            'Exterior Color',
            'Dealer Comment',
            'Status',
            'Created At',
            'Updated At',
            'Deleted At',
        ];
    }

    public function map($post): array
    {
        return [
            $post->id,
            $post->dealer_id,
            $post->dealer->name ?? 'N/A',
            $post->dealer->email ?? 'N/A',
            $post->title,
            $post->condition,
            $post->assembly,
            $post->company_conection,
            $post->currency,
            $post->price,
            $post->negotiated_price,
            $post->make,
            $post->model,
            $post->year,
            $post->milleage,
            $post->body_type,
            $post->doors,
            $post->fuel,
            $post->seating_capacity,
            $post->engine_capacity,
            $post->transmission,
            $post->drive_type,
            $post->exterior_color,
            $post->dealer_comment,
            $post->status == 0 ? 'In Review' : ($post->status == 1 ? 'Active' : 'Rejected'),
            $post->created_at ? $post->created_at->format('d M Y') : 'N/A',
            $post->updated_at ? $post->updated_at->format('d M Y') : 'N/A',
            $post->deleted_at ? $post->deleted_at->format('d M Y') : 'N/A',
        ];
    }
}