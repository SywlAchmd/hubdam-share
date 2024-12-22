<?php

namespace App\Filament\Admin\Resources\File\WordResource\Pages;

use App\Filament\Admin\Resources\File\WordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWords extends ListRecords
{
    protected static string $resource = WordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
