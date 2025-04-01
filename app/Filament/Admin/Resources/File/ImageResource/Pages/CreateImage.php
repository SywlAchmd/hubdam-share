<?php

namespace App\Filament\Admin\Resources\File\ImageResource\Pages;

use App\Filament\Admin\Resources\File\ImageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateImage extends CreateRecord
{
    protected static string $resource = ImageResource::class;

    protected static ?string $title = 'Buat Berkas';

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
