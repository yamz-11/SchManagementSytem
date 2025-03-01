<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassesResource\Pages;
use App\Filament\Resources\ClassesResource\RelationManagers;
use App\Models\Classes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassesResource extends Resource
{
    protected static ?string $model = Classes::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'School Management';
    protected static ?string $navigationLabel = 'Class';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Kelas'),
                Forms\Components\Select::make('teacher_id')
                    ->relationship('teacher', 'full_name')
                    ->searchable()
                    ->preload()
                    ->label('Wali Kelas'),
                Forms\Components\TextInput::make('academic_year')
                    ->required()
                    ->maxLength(255)
                    ->label('Tahun Akademik'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nama Kelas'),
                Tables\Columns\TextColumn::make('teacher_id')
                    ->searchable()
                    ->label('Wali Kelas'),
                Tables\Columns\TextColumn::make('academic_year')
                    ->searchable()
                    ->label('Tahun Akademik'),
                Tables\Columns\TextColumn::make('students_count')
                    ->counts('students')
                    ->label('Jumlah Siswa'),
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
                Tables\Filters\SelectFilter::make('teacher_id')
                    ->relationship('teacher', 'full_name')
                    ->searchable()
                    ->label('Wali Kelas'),
                Tables\Filters\Filter::make('academic_year')
                    ->form([
                        Forms\Components\TextInput::make('academic_year')
                            ->label('Tahun Akademik'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data['academic_year'],
                            fn($query) => $query->where('academic_year', 'like', "%{$data['academic_year']}%")
                        );
                    })
                    ->label('Tahun Akademik'),
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
            'index' => Pages\ListClasses::route('/'),
            'create' => Pages\CreateClasses::route('/create'),
            'edit' => Pages\EditClasses::route('/{record}/edit'),
        ];
    }
}
