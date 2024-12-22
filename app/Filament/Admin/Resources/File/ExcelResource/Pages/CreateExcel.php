<?php

namespace App\Filament\Admin\Resources\File\ExcelResource\Pages;

use App\Filament\Admin\Resources\File\ExcelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExcel extends CreateRecord
{
    protected static string $resource = ExcelResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
