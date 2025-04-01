<?php

namespace App\Filament\Admin\Resources\File\WordResource\Pages;

use App\Filament\Admin\Resources\File\WordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWord extends EditRecord
{
    protected static string $resource = WordResource::class;

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
