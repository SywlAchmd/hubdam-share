<?php

namespace App\Filament\Admin\Resources\File;

use App\Filament\Admin\Resources\File\PDFResource\Pages;
use App\Filament\Admin\Resources\File\PDFResource\RelationManagers;
use App\Helpers\FileHelper;
use App\Models\File;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

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
                // Forms\Components\FileUpload::make('fileName')
                //     ->acceptedFileTypes(['application/pdf'])
                //     ->directory('file-pdf')
                //     ->storeFileNamesIn('name')
                //     ->live()
                //     // ->afterStateUpdated(fn(Set $set, $state) => $set('size', Storage::disk('public')->size($state->fileName))),
                //     ->afterStateUpdated(function (Set $set, $state) {
                //         dd($state->filename);
                //     }),
                // Forms\Components\TextInput::make('size')
                Forms\Components\SpatieMediaLibraryFileUpload::make('File Upload')
                    ->acceptedFileTypes(['application/pdf'])
                    ->collection('file-pdf')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(null)
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Files')
                    ->getStateUsing(function ($record) {
                        $href = '
                                <a href="' . $record->getMedia('file-pdf')->first()->getUrl() . '" target="_blank" class="text-blue-400 underline text-sm">
                        ';

                        $fileName = $href . $record->getMedia('file-pdf')->first()->name . '</a>';

                        return $fileName;
                    })
                    ->html(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Waktu')
                    ->formatStateUsing(fn($state) => $state->format('H:i')),
                Tables\Columns\TextColumn::make('Size')
                    ->label('Size File')
                    ->getStateUsing(fn($record) => FileHelper::formatFileSize($record->getMedia('file-pdf')->first()->size))
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
            'index' => Pages\ListPDFS::route('/'),
            'create' => Pages\CreatePDF::route('/create'),
            'edit' => Pages\EditPDF::route('/{record}/edit'),
        ];
    }
}
