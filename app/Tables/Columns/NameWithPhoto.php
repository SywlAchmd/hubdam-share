<?php

namespace App\Tables\Columns;

use Filament\Tables\Columns\Column;
use Illuminate\Support\Facades\Storage;

class NameWithPhoto extends Column
{
    protected string $view = 'filament.tables.columns.name-with-photo';

    protected function setUp(): void
    {
        parent::setUp();

        $this->getStateUsing(function ($record) {
            return [
                'name' => $record->name,
                'image' => $this->getImageUrl($record->image),
            ];
        });
    }

    protected function getImageUrl(?string $path): string
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        return $this->getDefaultAvatar();
    }

    public function getDefaultAvatar(): string
    {
        return asset('assets/images/default_avatar.jpg');
    }
}
