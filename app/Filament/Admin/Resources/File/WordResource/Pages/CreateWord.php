<?php

namespace App\Filament\Admin\Resources\File\WordResource\Pages;

use App\Filament\Admin\Resources\File\WordResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWord extends CreateRecord
{
    protected static string $resource = WordResource::class;

    protected static ?string $title = 'Buat Dokumen';

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
