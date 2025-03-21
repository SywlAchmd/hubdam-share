<?php

namespace App\Filament\Admin\Resources\File;

use App\Filament\Admin\Resources\File\ImageResource\Pages;
use App\Filament\Admin\Resources\File\ImageResource\RelationManagers;
use App\Helpers\FileHelper;
use App\Models\File;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ImageResource extends Resource
{
    protected static ?string $model = File::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Gambar';

    protected static ?string $navigationGroup = 'Dokumen';

    protected static ?int $navigationSort = 5;

    protected static ?string $slug = 'images';

    protected static ?string $pluralLabel = "Gambar";

    protected static ?string $breadcrumb = "Gambar";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->user()->id),
                Forms\Components\SpatieMediaLibraryFileUpload::make('File Upload')
                    ->label('Unggah Dokumen')
                    ->image()
                    ->acceptedFileTypes(['image/*'])
                    ->imageEditor()
                    ->collection('file-image')
                    ->multiple()
                    ->reorderable()
                    ->columnSpanFull()
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Dokumen')
                    ->getStateUsing(function ($record) {
                        $files = $record->getMedia('file-image');

                        $fileList = $files->map(function ($file) {
                            return '<li><a href="' . $file->getUrl() . '" target="_blank" class="text-blue-400 underline text-sm">' . $file->name . '</a></li>';
                        })->implode('');

                        return '<ul>' . $fileList . '</ul>';
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas(
                            'media',
                            fn(Builder $query) =>
                            $query->where('name', 'like', '%' . $search . '%')
                        );
                    })
                    ->wrap()
                    ->html(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Waktu')
                    ->formatStateUsing(fn($state) => $state->format('d M Y, H:i')),
                Tables\Columns\TextColumn::make('Size')
                    ->label('Ukuran Dokumen')
                    ->getStateUsing(function ($record) {
                        $files = $record->getMedia('file-image');

                        return FileHelper::formatFileSize($files->sum('size'));
                    })
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHas('media', function (Builder $query) {
                    $query->where('collection_name', 'file-image');
                });
            })
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->color('info')
                    ->icon("heroicon-m-arrow-down-tray")
                    ->action(fn($record) => FileHelper::downloadFiles($record, 'file-image')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
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
            'index' => Pages\ListImages::route('/'),
            'create' => Pages\CreateImage::route('/create'),
            'edit' => Pages\EditImage::route('/{record}/edit'),
        ];
    }
}
