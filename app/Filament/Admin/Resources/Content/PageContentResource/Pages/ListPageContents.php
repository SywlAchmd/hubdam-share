<?php

namespace App\Filament\Admin\Resources\Content\PageContentResource\Pages;

use App\Filament\Admin\Resources\Content\PageContentResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListPageContents extends ListRecords
{
    protected static string $resource = PageContentResource::class;

    public function getTabs(): array
    {
        return [
            'Visi' => Tab::make()->query(fn($query) => $query->where('type', 'vision'))->icon('heroicon-m-eye'),
            'Misi' => Tab::make()->query(fn($query) => $query->where('type', 'mission'))->icon('heroicon-m-rocket-launch')
        ];
    }
}
