<?php

namespace App\Filament\Resources\Shop\OrderResource\Pages;

use App\Enums\OrderStatus;
use App\Filament\Resources\Shop\OrderResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'new' => Tab::make()->query(fn ($query) => $query->where('status', OrderStatus::New)),
            'processing' => Tab::make()->query(fn ($query) => $query->where('status', OrderStatus::Processing)),
            'shipped' => Tab::make()->query(fn ($query) => $query->where('status', OrderStatus::Shipped)),
            'delivered' => Tab::make()->query(fn ($query) => $query->where('status', OrderStatus::Delivered)),
            'cancelled' => Tab::make()->query(fn ($query) => $query->where('status', OrderStatus::Cancelled)),
        ];
    }
}