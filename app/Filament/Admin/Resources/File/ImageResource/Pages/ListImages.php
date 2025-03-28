<?php

namespace App\Filament\Admin\Resources\File\ImageResource\Pages;

use App\Filament\Admin\Resources\File\ImageResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
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

    public function getTabs(): array
    {
        return [
            null => Tab::make('Semua'),
            'mine' => Tab::make('Saya')->query(fn ($query) => $query->where('user_id', auth()->user()->id)),
            'others' => Tab::make('Staff Lain')->query(fn ($query) => $query->where('user_id', '!=' , auth()->user()->id)),
        ];
    }
}
