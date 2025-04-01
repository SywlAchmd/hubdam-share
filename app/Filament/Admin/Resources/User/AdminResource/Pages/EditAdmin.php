<?php

namespace App\Filament\Admin\Resources\User\AdminResource\Pages;

use App\Filament\Admin\Resources\User\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    public function getTitle(): string
    {
        return ('Ubah Admin');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return auth()->user()->id === $this->record->id
        ? []
        : [
            Actions\DeleteAction::make()
                ->modalHeading("Hapus Admin")
        ];
    }
}
