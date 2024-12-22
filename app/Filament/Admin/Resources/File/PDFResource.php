<?php

namespace App\Filament\Admin\Resources\File;

use App\Filament\Admin\Resources\File\PDFResource\Pages;
use App\Filament\Admin\Resources\File\PDFResource\RelationManagers;
use App\Helpers\FileHelper;
use App\Models\File;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use ZipArchive;

class PDFResource extends Resource
{
    protected static ?string $model = File::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'PDF';

    protected static ?string $navigationGroup = 'Files';

    protected static ?int $navigationsort = 1;

    protected static ?string $slug = 'pdf';

    public static function getPluralLabel(): ?string
    {
        return ('PDF');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->user()->id),
                Forms\Components\SpatieMediaLibraryFileUpload::make('File Upload')
                    ->label('Upload File')
                    ->acceptedFileTypes(['application/pdf'])
                    ->collection('file-pdf')
                    ->multiple()
                    ->reorderable()
                    ->columnSpanFull()
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Files')
                    ->getStateUsing(function ($record) {
                        $files = $record->getMedia('file-pdf');

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
                    ->formatStateUsing(fn($state) => $state->format('H:i')),
                Tables\Columns\TextColumn::make('Size')
                    ->label('Size Files')
                    ->getStateUsing(function ($record) {
                        $files = $record->getMedia('file-pdf');

                        return FileHelper::formatFileSize($files->sum('size'));
                    })
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHas('media', function (Builder $query) {
                    $query->where('collection_name', 'file-pdf');
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
                    ->action(function ($record) {
                        $files = $record->getMedia('file-pdf');

                        if ($files->count() == 1) {
                            $file = $files->first();

                            return response()->download($file->getPath(), $file->name, [
                                'Content-type' => $file->mime_type
                            ]);
                        }

                        $zip = new ZipArchive();

                        $zipFileName = 'files-pdf-' . now()->format('Y-m-d_H-i-s') . '.zip';
                        $zipPath = storage_path('app/public/' . $zipFileName);

                        if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
                            foreach ($files as $file) {
                                $filePath = $file->getPath();
                                $fileName = $file->name . '.pdf';

                                $zip->addFile($filePath, $fileName);
                            }

                            $zip->close();
                        }

                        return response()->download($zipPath)->deleteFileAfterSend(true);
                    })
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
            'index' => Pages\ListPDFS::route('/'),
            'create' => Pages\CreatePDF::route('/create'),
            'edit' => Pages\EditPDF::route('/{record}/edit'),
        ];
    }
}
