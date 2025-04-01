<?php

namespace App\Filament\Admin\Resources\File\ImageResource\Pages;

use App\Filament\Admin\Resources\File\ImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImage extends EditRecord
{
    protected static string $resource = ImageResource::class;

    protected static ?string $title = 'Ubah Berkas';

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->modalHeading("Hapus Berkas"),
        ];
    }
}
