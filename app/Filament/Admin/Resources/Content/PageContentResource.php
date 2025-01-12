<?php

namespace App\Filament\Admin\Resources\Content;

use App\Filament\Admin\Resources\Content\PageContentResource\Pages;
use App\Filament\Admin\Resources\Content\PageContentResource\RelationManagers;
use App\Models\PageContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageContentResource extends Resource
{
    protected static ?string $model = PageContent::class;

    protected static ?string $navigationIcon = 'phosphor-browsers';

    protected static ?string $slug = 'page-content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        'vision' => 'Visi',
                        'mission' => 'Misi',
                    ])
                    ->native(false)
                    ->required()
                    ->columnSpanFull()
                    ->reactive()
                    ->disabled(fn($record) => $record !== null)
                    ->hidden(fn($record) => $record !== null),

                Forms\Components\MarkdownEditor::make('content')
                    ->label(fn($record) => $record ? match ($record->type) {
                        'vision' => 'Visi',
                        'mission' => 'Misi',
                        default => 'Content',
                    } : 'Content')
                    ->required()
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'heading',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'undo',
                    ])
                    ->columnSpanFull()
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn($record) => match ($record->type) {
                'vision' => 'Visi',
                'mission' => 'Misi'
            })
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('content')->wrap(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPageContents::route('/'),
        ];
    }
}
