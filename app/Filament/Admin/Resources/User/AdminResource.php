<?php

namespace App\Filament\Admin\Resources\User;

use App\Filament\Admin\Resources\User\AdminResource\Pages;
use App\Filament\Admin\Resources\AdminResource\RelationManagers;
use App\Helpers\FileHelper;
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

class AdminResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'phosphor-shield-checkered';

    protected static ?string $navigationLabel = 'Admin';

    protected static ?string $navigationGroup = 'Pengguna';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'admins';

    public static function getPluralLabel(): ?string
    {
        return ('Admin');
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->role == '0';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->heading('Data Admin')
                    ->description('Masukan informasi admin di sini')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label("Nama")
                            ->required(),
                        Forms\Components\TextInput::make('username')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('email')
                            ->required()
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
                            ])
                            ->default('1')
                            ->native(false)
                            ->required(),
                        Forms\Components\Select::make('staff')
                            ->label('Staf')
                            ->searchable()
                            ->options(FileHelper::getStaffOptions())
                            ->native(false)
                    ])
                    ->columns(2),
                Forms\Components\Section::make()
                    ->heading('Foto Profil')
                    ->description('Unggah foto di sini')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label("Gambar")
                            ->image()
                            ->acceptedFileTypes(['image/*'])
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1')
                            ->directory('user-images')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading("Tidak ada admin yang ditemukan")
            ->emptyStateDescription("Buat admin untuk memulai")
            ->defaultSort('role', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label("Nama")
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
                        '0' => 'Superadmin',
                        '1' => 'Admin',
                        '2' => 'Staf',
                    }),
                Tables\Columns\TextColumn::make('staff')
                    ->label('Staf')
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        $options = FileHelper::getStaffOptions();
                        return $options[$state] ?? $state;
                    })
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->where('role', '!=', '2'))
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->native(false)
                    ->options([
                        '0' => 'Superadmin',
                        '1' => 'Admin',
                    ])
                    ->label('Role'),
                Tables\Filters\SelectFilter::make('staff')
                    ->native(false)
                    ->searchable()
                    ->options(FileHelper::getStaffOptions())
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
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
