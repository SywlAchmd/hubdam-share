<?php

namespace App\Filament\Admin\Resources\User;

use App\Filament\Admin\Resources\User\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'User';

    protected static ?string $navigationGroup = 'User';

    protected static ?int $navigationsort = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', '!=', '0');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->heading('User Data')
                    ->description('Masukan informasi pengguna di sini')
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
                        Forms\Components\Select::make('staff')
                            ->searchable()
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
                            ->columnSpanFull()
                            ->native(false)
                    ])
                    ->columns(2),
                Forms\Components\Section::make()
                    ->heading('Foto Profil')
                    ->description('Upload foto pengguna di sini')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1')
                            ->directory('user-images')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->icon(fn(User $record) => $record->image ? Storage::disk('public')->url($record->image) : asset('assets/images/default_avatar.jpg'))
                    ->size(Tables\Columns\TextColumn\TextColumnSize::Medium)
                    ->weight(\Filament\Support\Enums\FontWeight::Medium)
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->formatStateUsing(fn($state) => match ($state) {
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}