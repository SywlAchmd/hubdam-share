<?php

namespace App\Filament\Admin\Resources\File\ExcelResource\Pages;

use App\Filament\Admin\Resources\File\ExcelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExcels extends ListRecords
{
    protected static string $resource = ExcelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
