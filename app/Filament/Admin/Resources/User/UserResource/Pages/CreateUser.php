<?php

namespace App\Filament\Admin\Resources\User\UserResource\Pages;

use App\Filament\Admin\Resources\User\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'Buat Pengguna';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
