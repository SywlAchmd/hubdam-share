<?php

namespace App\Filament\Admin\Resources\File\PDFResource\Pages;

use App\Filament\Admin\Resources\File\PDFResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePDF extends CreateRecord
{
    protected static string $resource = PDFResource::class;

    protected static ?string $title = 'Buat Dokumen';

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
