<?php

namespace App\Filament\Resources\Blog\PostResource\Pages;

use App\Enums\PostStatus;
use App\Filament\Resources\Blog\PostResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'draft' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', PostStatus::Draft)),
            'reviewing' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', PostStatus::Reviewing)),
            'published' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', PostStatus::Published)),
            'rejected' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', PostStatus::Rejected)),
        ];
    }
}
