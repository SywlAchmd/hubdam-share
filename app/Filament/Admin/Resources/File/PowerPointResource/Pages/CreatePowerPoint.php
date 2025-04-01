<?php

namespace App\Filament\Admin\Resources\File\PowerPointResource\Pages;

use App\Filament\Admin\Resources\File\PowerPointResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePowerPoint extends CreateRecord
{
    protected static string $resource = PowerPointResource::class;

    protected static ?string $title = 'Buat Berkas';

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
