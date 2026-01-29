<?php

// app/Exports/OrderExport.php
namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection, WithHeadings
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function collection()
    {
        $data = [
            [
                'Order ID' => $this->order->order_number,
                'Date' => $this->order->created_at->format('Y-m-d H:i:s'),
                'Customer' => $this->order->user->name,
                'Email' => $this->order->user->email,
                'Phone' => $this->order->user->phone,
                'Total' => $this->order->total,
                'Status' => $this->order->status,
                'Payment' => $this->order->payment_method,
            ]
        ];
        
        foreach ($this->order->items as $item) {
            $data[] = [
                'Product' => $item->product_name,
                'Category' => $item->category_name,
                'Quantity' => $item->quantity,
                'Price' => $item->price,
                'Subtotal' => $item->total,
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Order Details',
            'Value',
            '', '', '', '', '', ''
        ];
    }
}