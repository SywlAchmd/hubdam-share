<?php

namespace App\Filament\Admin\Resources\File\PowerPointResource\Pages;

use App\Filament\Admin\Resources\File\PowerPointResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPowerPoint extends EditRecord
{
    protected static string $resource = PowerPointResource::class;

    protected static ?string $title = 'Edit Dokumen';

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
