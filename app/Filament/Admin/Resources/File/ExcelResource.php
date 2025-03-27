<?php

namespace App\Filament\Admin\Resources\File;

use App\Filament\Admin\Resources\File\ExcelResource\Pages;
use App\Filament\Admin\Resources\File\ExcelResource\RelationManagers;
use App\Helpers\FileHelper;
use App\Models\File;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExcelResource extends Resource
{

    protected static ?string $model = File::class;

    protected static ?string $navigationIcon = 'phosphor-microsoft-excel-logo';

    protected static ?string $navigationLabel = 'Excel';

    protected static ?string $navigationGroup = 'Dokumen';

    protected static ?int $navigationSort = 4;

    protected static ?string $slug = 'excel';

    public static function getPluralLabel(): ?string
    {
        return ('Excel');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->user()->id),
                Forms\Components\SpatieMediaLibraryFileUpload::make('File Upload')
                    ->label('Unggah Dokumen')
                    ->acceptedFileTypes([
                        "text/csv",
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    ])
                    ->collection('file-excel')
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
	        Tables\Columns\TextColumn::make('user.staff')
                    ->label('Staff')
                    ->searchable()
                    ->formatStateUsing(fn ($state) => FileHelper::getStaffOptions()[$state]),
                Tables\Columns\TextColumn::make('Files')
                    ->label("Dokumen")
                    ->getStateUsing(function ($record) {
                        $files = $record->getMedia('file-excel');

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
                        $files = $record->getMedia('file-excel');

                        return FileHelper::formatFileSize($files->sum('size'));
                    })
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHas('media', function (Builder $query) {
                    $query->where('collection_name', 'file-excel');
                });
            })
	    ->filters([
                Tables\Filters\Filter::make('staff')->form([
                    Forms\Components\Select::make('staff')
                        ->label('Staff')
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

                    return 'Staff: ' . FileHelper::getStaffOptions()[$staff] ?? $staff;
                })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->color('info')
                    ->icon("heroicon-m-arrow-down-tray")
                    ->action(fn($record) => FileHelper::downloadFiles($record, 'file-excel')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListExcels::route('/'),
            'create' => Pages\CreateExcel::route('/create'),
            'edit' => Pages\EditExcel::route('/{record}/edit'),
        ];
    }
}
