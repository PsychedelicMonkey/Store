<?php

namespace App\Filament\Resources\Blog;

use App\Enums\PostStatus;
use App\Filament\Resources\Blog\PostResource\Pages;
use App\Models\Blog\Post;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $slug = 'blog/posts';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Blog';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 0;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->maxLength(255)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->maxLength(255)
                            ->required()
                            ->unique(Post::class, 'slug', ignoreRecord: true),

                        Forms\Components\Select::make('blog_author_id')
                            ->relationship('author', 'name')
                            ->required()
                            ->searchable(),

                        Forms\Components\Select::make('blog_category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable(),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->native(false)
                            ->placeholder(now()->format('M d, Y H:m:s'))
                            ->required(),

                        Forms\Components\ToggleButtons::make('status')
                            ->inline()
                            ->options(PostStatus::class)
                            ->required(),

                        Forms\Components\SpatieTagsInput::make('tags'),
                    ])
                    ->columns(),

                Forms\Components\Section::make('Image')
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                            ->collection('post-images')
                            ->hiddenLabel()
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('3:2')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('800')
                            ->responsiveImages()
                            ->required(),
                    ]),

                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->columnSpanFull()
                            ->hiddenLabel()
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('author.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->searchable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->date()
                    ->label('Date published')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),

                Tables\Filters\Filter::make('published_at')
                    ->form([
                        Forms\Components\DatePicker::make('published_from')
                            ->native(false)
                            ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),

                        Forms\Components\DatePicker::make('published_until')
                            ->native(false)
                            ->placeholder(fn ($state): string => now()->format('M d, Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['published_from'] ?? null) {
                            $indicators['published_from'] = 'Published from ' . Carbon::parse($data['published_from'])->toFormattedDateString();
                        }
                        if ($data['published_until'] ?? null) {
                            $indicators['published_until'] = 'Published until ' . Carbon::parse($data['published_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc')
            ->emptyStateHeading('No posts yet')
            ->emptyStateDescription('Once you write your first post, it will appear here.')
            ->emptyStateIcon('heroicon-o-bookmark')
            ->emptyStateActions([
                Tables\Actions\Action::make('create')
                    ->label('Create post')
                    ->url(self::getUrl('create'))
                    ->icon('heroicon-m-plus')
                    ->button(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make()
                    ->schema([
                        Components\Split::make([
                            Components\Grid::make(2)
                                ->schema([
                                    Components\Group::make([
                                        Components\TextEntry::make('title'),
                                        Components\TextEntry::make('slug'),
                                        Components\TextEntry::make('published_at')
                                            ->badge()
                                            ->color('success')
                                            ->date(),
                                    ]),
                                    Components\Group::make([
                                        Components\TextEntry::make('author.name'),
                                        Components\TextEntry::make('category.name'),
                                        Components\SpatieTagsEntry::make('tags'),
                                    ]),
                                ]),

                            Components\SpatieMediaLibraryImageEntry::make('image')
                                ->collection('post-images')
                                ->grow(false)
                                ->hiddenLabel(),
                        ])->from('lg'),
                    ]),

                Components\Section::make('Content')
                    ->schema([
                        Components\TextEntry::make('content')
                            ->hiddenLabel()
                            ->html()
                            ->prose(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'comments' => Pages\ManagePostComments::route('/{record}/comments'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewPost::class,
            Pages\EditPost::class,
            Pages\ManagePostComments::class,
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'slug', 'author.name', 'category.name'];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['author', 'category']);
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Post $record */

        return [
            'Author' => optional($record->author)->name,
            'Category' => optional($record->category)->name,
        ];
    }
}
