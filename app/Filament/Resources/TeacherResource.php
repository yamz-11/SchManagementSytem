<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'School Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun')
                    ->schema([
                        Forms\Components\TextInput::make('user_id')
                            ->required()
                            ->label('Nama Login'),
                        Forms\Components\TextInput::make('user.email')
                            ->required()
                            ->email()
                            ->unique(User::class, 'email', ignoreRecord: true)
                            ->label('Email'),
                        Forms\Components\TextInput::make('user.password')
                            ->password()
                            ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->label('Password'),
                        // ]),
                        // Forms\Components\Section::make('Informasi Guru')
                        //       ->schema([
                        Forms\Components\TextInput::make('nip')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label('NIP'),
                        Forms\Components\TextInput::make('full_name')
                            ->required()
                            ->label('Nama Lengkap'),
                        Forms\Components\Select::make('gender')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required()
                            ->label('Jenis Kelamin'),
                        Forms\Components\TextInput::make('address')
                            ->required()
                            ->label('Alamat'),
                        Forms\Components\TextInput::make('phone_number')
                            ->tel()
                            ->required()
                            ->label('Nomor Telepon'),
                        Forms\Components\TextInput::make('specialization')
                            ->required()
                            ->label('Spesialisasi'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('user_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('nip')
                    ->searchable()
                    ->label('NIP'),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->label('Nama Lengkap'),
                Tables\Columns\TextColumn::make('specialization')
                    ->searchable()
                    ->label('Spesialisasi'),

                // Tables\Columns\TextColumn::make('gender'),
                // Tables\Columns\TextColumn::make('address')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->searchable()
                    ->label('Email'),
                // Tables\Columns\TextColumn::make('phone_number')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Dibuat Pada'),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->label('Jenis Kelamin'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
