<?php

namespace App\Filament\Admin\Resources\File\PowerPointResource\Pages;

use App\Filament\Admin\Resources\File\PowerPointResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
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

    public function getTabs(): array
    {
        return [
            null => Tab::make('Semua'),
            'Saya' => Tab::make()->query(fn ($query) => $query->where('user_id', auth()->user()->id)),
            'Staff Lain' => Tab::make()->query(fn ($query) => $query->where('user_id', '!=' , auth()->user()->id)),
        ];
    }
}
