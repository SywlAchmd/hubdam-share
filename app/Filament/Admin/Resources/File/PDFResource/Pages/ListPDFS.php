<?php

namespace App\Filament\Admin\Resources\File\PDFResource\Pages;

use App\Filament\Admin\Resources\File\PDFResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPDFS extends ListRecords
{
    protected static string $resource = PDFResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
