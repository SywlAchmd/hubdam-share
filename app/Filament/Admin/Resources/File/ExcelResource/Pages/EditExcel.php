<?php

namespace App\Filament\Admin\Resources\File\ExcelResource\Pages;

use App\Filament\Admin\Resources\File\ExcelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExcel extends EditRecord
{
    protected static string $resource = ExcelResource::class;

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
