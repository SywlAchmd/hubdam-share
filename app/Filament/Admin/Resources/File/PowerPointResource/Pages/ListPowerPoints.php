<?php

namespace App\Filament\Admin\Resources\File\PowerPointResource\Pages;

use App\Filament\Admin\Resources\File\PowerPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPowerPoints extends ListRecords
{
    protected static string $resource = PowerPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
