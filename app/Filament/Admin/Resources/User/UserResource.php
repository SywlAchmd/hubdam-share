<?php

namespace App\Filament\Admin\Resources\User;

use App\Filament\Admin\Resources\User\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Helpers\FileHelper;
use App\Models\User;
use App\Tables\Columns\NameWithPhoto;
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

    protected static ?string $navigationIcon = 'phosphor-user';

    protected static ?string $navigationLabel = 'Pengguna';

    protected static ?string $navigationGroup = 'Pengguna';

    protected static ?int $navigationSort = 2;

    protected static ?string $slug = 'users';

    protected static ?string $breadcrumb = "Pengguna";

    protected static ?string $pluralLabel = "Pengguna";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->heading('Data Pengguna')
                    ->description('Masukan informasi pengguna di sini')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label("Nama")
                            ->required(),
                        Forms\Components\TextInput::make('username')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()    
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('password')
                            ->translateLabel()
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => \filled($state))
                            ->required(fn(string $context): bool => $context === 'create'),
                        Forms\Components\Select::make('role')
                            ->options([
                                '1' => 'Admin',
                                '2' => 'Staf'
                            ])
                            ->native(false)
                            ->required()
                            ->columnSpanFull()
                            ->hidden(fn (string $operation): bool => $operation === 'create' || auth()->user()->role != 0),
                        Forms\Components\Select::make('staff')
                            ->label('Staf')
                            ->searchable()
                            ->options(FileHelper::getStaffOptions())
                            ->default(fn() => auth()->user()->staff ?? null)
                            ->disabled(auth()->user()->role != 0)
                            ->dehydrated()
                            ->columnSpanFull()
                            ->native(false)
                    ])
                    ->columns(2),
                Forms\Components\Section::make()
                    ->heading('Foto Profil')
                    ->description('Unggah foto pengguna di sini')
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
            ->emptyStateHeading("Tidak ada pengguna yang ditemukan")
            ->emptyStateDescription("Buat pengguna untuk memulai")
            ->defaultSort('role', 'asc')
            ->columns([
                NameWithPhoto::make('name')
                    ->label("Nama")
                    // ->icon(fn(User $record) => $record->image ? Storage::disk('public')->url($record->image) : asset('assets/images/default_avatar.jpg'))
                    // ->size(Tables\Columns\TextColumn\TextColumnSize::Medium)
                    // ->weight(\Filament\Support\Enums\FontWeight::Medium)
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->formatStateUsing(fn($state) => match ($state) {
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
            ->modifyQueryUsing(fn(Builder $query) => $query->where('role', '!=', '0'))
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->native(false)
                    ->options([
                        '1' => 'Admin',
                        '2' => 'Staf',
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
