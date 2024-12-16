<?php

namespace App\Filament\Clusters\Products\Resources;

use App\Filament\Clusters\Products;
use App\Filament\Clusters\Products\Resources\ProductResource\Pages;
use App\Filament\Clusters\Products\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Products::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('shop_brand_id')
                    ->numeric(),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('slug'),
                Forms\Components\TextInput::make('sku')
                    ->label('SKU'),
                Forms\Components\TextInput::make('barcode'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('qty')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('security_stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('featured')
                    ->required(),
                Forms\Components\Toggle::make('is_visible')
                    ->required(),
                Forms\Components\TextInput::make('old_price')
                    ->numeric(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('cost')
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('status'),
                Forms\Components\Toggle::make('backorder')
                    ->required(),
                Forms\Components\Toggle::make('requires_shipping')
                    ->required(),
                Forms\Components\DatePicker::make('published_at'),
                Forms\Components\TextInput::make('weight_value')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('weight_unit')
                    ->required(),
                Forms\Components\TextInput::make('height_value')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('height_unit')
                    ->required(),
                Forms\Components\TextInput::make('width_value')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('width_unit')
                    ->required(),
                Forms\Components\TextInput::make('depth_value')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('depth_unit')
                    ->required(),
                Forms\Components\TextInput::make('volume_value')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('volume_unit')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('shop_brand_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('barcode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('security_stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean(),
                Tables\Columns\TextColumn::make('old_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cost')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\IconColumn::make('backorder')
                    ->boolean(),
                Tables\Columns\IconColumn::make('requires_shipping')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('weight_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('weight_unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('height_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('height_unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('width_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('width_unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('depth_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('depth_unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('volume_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('volume_unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
