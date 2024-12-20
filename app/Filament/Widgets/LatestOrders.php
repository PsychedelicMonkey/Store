<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Shop\OrderResource;
use App\Models\Shop\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Squire\Models\Currency;

class LatestOrders extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->label('Order Date')
                    ->sortable(),

                Tables\Columns\TextColumn::make('number')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge(),

                Tables\Columns\TextColumn::make('currency')
                    ->getStateUsing(fn ($record): ?string => Currency::find($record->currency)?->name ?? null)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_price')
                    ->numeric()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('shipping_price')
                    ->label('Shipping cost')
                    ->searchable()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->url(fn (Order $order) => OrderResource::getUrl('edit', ['record' => $order])),
            ]);
    }
}
