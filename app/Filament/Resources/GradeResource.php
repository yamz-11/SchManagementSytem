<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GradeResource\Pages;
use App\Filament\Resources\GradeResource\RelationManagers;
use App\Models\Grade;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Academic Management';
    protected static ?string $navigationLabel = 'Grade';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'full_name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Siswa'),
                Forms\Components\Select::make('subject_id')
                    ->relationship('subject', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Mata Pelajaran'),
                Forms\Components\Select::make('teacher_id')
                    ->relationship('teacher', 'full_name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Guru'),
                Forms\Components\TextInput::make('semester')
                    ->required()
                    ->maxLength(255)
                    ->label('Semester'),
                Forms\Components\TextInput::make('score')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->label('Nilai'),
                Forms\Components\Textarea::make('remarks')
                    ->maxLength(65535)
                    ->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.full_name')
                    ->searchable()
                    ->label('Siswa'),
                Tables\Columns\TextColumn::make('subject.name')
                    ->searchable()
                    ->label('Mata Pelajaran'),
                Tables\Columns\TextColumn::make('teacher.full_name')
                    ->searchable()
                    ->label('Guru'),
                Tables\Columns\TextColumn::make('semester')
                    ->searchable()
                    ->label('Semester'),
                Tables\Columns\TextColumn::make('score')
                    ->numeric()
                    ->sortable()
                    ->label('Nilai'),
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
                Tables\Filters\SelectFilter::make('student_id')
                    ->relationship('student', 'full_name')
                    ->label('Siswa'),
                Tables\Filters\SelectFilter::make('subject_id')
                    ->relationship('subject', 'name')
                    ->label('Mata Pelajaran'),
                Tables\Filters\SelectFilter::make('teacher_id')
                    ->relationship('teacher', 'full_name')
                    ->label('Guru'),
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
            'index' => Pages\ListGrades::route('/'),
            'create' => Pages\CreateGrade::route('/create'),
            'edit' => Pages\EditGrade::route('/{record}/edit'),
        ];
    }
}
