<?php

namespace App\Filament\Admin\Resources\Content\PageContentResource\Pages;

use App\Filament\Admin\Resources\Content\PageContentResource;
use App\Models\PageContent;
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

    protected function getHeaderActions(): array
    {
        $visiExist = PageContent::where('type', 'vision')->exists();
        $misiExist = PageContent::where('type', 'mission')->exists();

        if (!$visiExist || !$misiExist) {
            return [
                Actions\CreateAction::make()->modalHeading("Buat Konten Halaman"),
            ];
        }

        return [];
    }
}
