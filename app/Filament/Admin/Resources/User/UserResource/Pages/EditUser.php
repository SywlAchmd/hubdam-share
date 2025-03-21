<?php

namespace App\Filament\Admin\Resources\User\UserResource\Pages;

use App\Filament\Admin\Resources\User\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'Edit Pengguna';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        if (
            auth()->user()->id === $this->record->id || 
            in_array($this->record->role, [0, 1])
        ) {
            return [];
        }
    
        return [Actions\DeleteAction::make()];
    }
}
