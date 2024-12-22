<?php

namespace App\Filament\Admin\Resources\File\ImageResource\Pages;

use App\Filament\Admin\Resources\File\ImageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImages extends ListRecords
{
    protected static string $resource = ImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
