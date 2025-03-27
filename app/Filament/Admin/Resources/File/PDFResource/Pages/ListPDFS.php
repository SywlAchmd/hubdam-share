<?php

namespace App\Filament\Admin\Resources\File\PDFResource\Pages;

use App\Filament\Admin\Resources\File\PDFResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
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

    public function getTabs(): array
    {
        return [
            null => Tab::make('Semua'),
            'Saya' => Tab::make()->query(fn ($query) => $query->where('user_id', auth()->user()->id)),
            'Staff Lain' => Tab::make()->query(fn ($query) => $query->where('user_id', '!=' , auth()->user()->id)),
        ];
    }
}
