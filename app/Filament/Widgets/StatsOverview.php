<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classes;
use App\Models\Assignment;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Siswa', Student::count())
                ->description('Jumlah keseluruhan siswa')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),

            Stat::make('Total Guru', Teacher::count())
                ->description('Jumlah keseluruhan guru')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Total Kelas', Classes::count())
                ->description('Jumlah keseluruhan kelas')
                ->descriptionIcon('heroicon-m-building-library')
                ->color('success'),

            Stat::make('Tugas Aktif', Assignment::where('due_date', '>=', now())->count())
                ->description('Jumlah tugas yang masih aktif')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('warning'),
        ];
    }
}
