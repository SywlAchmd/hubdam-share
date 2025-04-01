<?php

namespace App\Filament\Admin\Resources\File;

use App\Filament\Admin\Resources\File\PowerPointResource\Pages;
use App\Filament\Admin\Resources\File\PowerPointResource\RelationManagers;
use App\Helpers\FileHelper;
use App\Models\File;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PowerPointResource extends Resource
{
    protected static ?string $model = File::class;

    protected static ?string $navigationIcon = 'phosphor-microsoft-powerpoint-logo';

    protected static ?string $navigationLabel = 'Power Point';

    protected static ?string $navigationGroup = 'Berkas';

    protected static ?int $navigationSort = 4;

    protected static ?string $slug = 'powerpoint';

    public static function getPluralLabel(): ?string
    {
        return ('Power Point');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->user()->id),
                Forms\Components\SpatieMediaLibraryFileUpload::make('File Upload')
                    ->label('Unggah Berkas')
                    ->acceptedFileTypes([
                        "application/vnd.ms-powerpoint",
                        "application/vnd.openxmlformats-officedocument.presentationml.presentation"
                    ])
                    ->collection('file-ppt')
                    ->multiple()
                    ->reorderable()
                    ->columnSpanFull()
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading("Tidak ada berkas yang ditemukan")
            ->emptyStateDescription("Buat berkas untuk memulai")
            ->defaultSort('updated_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable(),
	        Tables\Columns\TextColumn::make('user.staff')
                    ->label('Staf')
                    ->searchable()
                    ->formatStateUsing(fn ($state) => FileHelper::getStaffOptions()[$state]),
                Tables\Columns\TextColumn::make('Files')
                    ->label("Berkas")
                    ->getStateUsing(function ($record) {
                        $files = $record->getMedia('file-ppt');

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
                    ->label('Ukuran Berkas')
                    ->getStateUsing(function ($record) {
                        $files = $record->getMedia('file-ppt');

                        return FileHelper::formatFileSize($files->sum('size'));
                    })
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHas('media', function (Builder $query) {
                    $query->where('collection_name', 'file-ppt');
                });
            })
	    ->filters([
                Tables\Filters\Filter::make('staff')->form([
                    Forms\Components\Select::make('staff')
                        ->label('Staf')
                        ->options(FileHelper::getStaffOptions())
                        ->searchable()
                        ->preload()
                        ->native(false)
                ])
                ->query(function (Builder $query, array $data): Builder {
                    $staff = $data['staff'] ?? null;

                    if (! $staff) {
                        return $query;
                    }

                    return $query->whereHas('user', function (Builder $userQuery) use ($staff) {
                        return $userQuery->where('staff', $staff);
                    });
                })
                ->indicateUsing(function (array $data): ?string {
                    $staff = $data['staff'] ?? null;

                    if (! $staff) {
                        return null;
                    }

                    return 'Staf: ' . FileHelper::getStaffOptions()[$staff] ?? $staff;
                })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Unduh')
                    ->color('info')
                    ->icon("heroicon-m-arrow-down-tray")
                    ->action(fn($record) => FileHelper::downloadFiles($record, 'file-ppt')),
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
            'index' => Pages\ListPowerPoints::route('/'),
            'create' => Pages\CreatePowerPoint::route('/create'),
            'edit' => Pages\EditPowerPoint::route('/{record}/edit'),
        ];
    }
}
