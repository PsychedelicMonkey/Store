<?php

namespace App\Filament\Clusters\Products\Resources\ProductResource\Widgets;

use App\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ProductStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListProducts::class;
    }

    protected function getStats(): array
    {
        return [
            BaseWidget\Stat::make('Total Products', $this->getPageTableQuery()->count()),
            BaseWidget\Stat::make('Product Inventory', $this->getPageTableQuery()->sum('qty')),
            BaseWidget\Stat::make('Average Price', number_format($this->getPageTableQuery()->avg('price'), 2)),
        ];
    }
}
