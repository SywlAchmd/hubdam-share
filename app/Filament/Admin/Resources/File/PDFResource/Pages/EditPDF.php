<?php

namespace App\Filament\Admin\Resources\File\PDFResource\Pages;

use App\Filament\Admin\Resources\File\PDFResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPDF extends EditRecord
{
    protected static string $resource = PDFResource::class;

    protected static ?string $title = 'Ubah Dokumen';

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
