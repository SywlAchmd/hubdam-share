<?php

namespace App\Filament\Admin\Resources\User;

use App\Filament\Admin\Resources\User\AdminResource\Pages;
use App\Filament\Admin\Resources\AdminResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class AdminResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Admin';

    protected static ?string $navigationGroup = 'User';

    protected static ?int $navigationsort = 1;

    public static function getPluralLabel(): ?string
    {
        return ('Admin');
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->role == '0';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', '!=', '2');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('username')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->translateLabel()
                    ->password()
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => \filled($state))
                    ->required(fn(string $context): bool => $context === 'create'),
                Forms\Components\Select::make('role')
                    ->options([
                        '0' => 'Superadmin',
                        '1' => 'Admin',
                        '2' => 'Staff',
                    ])
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('staff')
                    ->options([
                        'pers' => 'Staf Tuud/Pers',
                        'sikomlek' => 'Sikomlek',
                        'pernika' => 'Staf Pernika',
                        'konbekharstal' => 'Konbekharstal',
                        'benghubdam' => 'Benghubdam',
                        'gudmathub' => 'Gudmathub',
                        'urlog' => 'Urlog',
                        'urlat' => 'Urlat',
                        'urpam' => 'Urpam',
                        'renproggar' => 'Renproggar',
                        'denhubdam' => 'Denhubdam'
                    ])
                    ->native(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('role', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->formatStateUsing(fn($state) => match ($state) {
                        '0' => 'Superadmin',
                        '1' => 'Admin',
                        '2' => 'Staff',
                    }),
                Tables\Columns\TextColumn::make('staff')
                    ->searchable()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'pers' => 'Staf Tuud/Pers',
                        'sikomlek' => 'Sikomlek',
                        'pernika' => 'Staf Pernika',
                        'konbekharstal' => 'Konbekharstal',
                        'benghubdam' => 'Benghubdam',
                        'gudmathub' => 'Gudmathub',
                        'urlog' => 'Urlog',
                        'urlat' => 'Urlat',
                        'urpam' => 'Urpam',
                        'renproggar' => 'Renproggar',
                        'denhubdam' => 'Denhubdam'
                    })
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->native(false)
                    ->options([
                        '0' => 'Superadmin',
                        '1' => 'Admin',
                        '2' => 'Staff',
                    ])
                    ->label('Role'),
                Tables\Filters\SelectFilter::make('staff')
                    ->native(false)
                    ->options([
                        'pers' => 'Staf Tuud/Pers',
                        'sikomlek' => 'Sikomlek',
                        'pernika' => 'Staf Pernika',
                        'konbekharstal' => 'Konbekharstal',
                        'benghubdam' => 'Benghubdam',
                        'gudmathub' => 'Gudmathub',
                        'urlog' => 'Urlog',
                        'urlat' => 'Urlat',
                        'urpam' => 'Urpam',
                        'renproggar' => 'Renproggar',
                        'denhubdam' => 'Denhubdam'
                    ])
                    ->label('Staf')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
        ];
    }
}
