<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Employee;
use App\Models\AssessmentProgram;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalKaryawan = \DB::table('employees')->where('status', 'Aktif')->count();
        $evaluasiAktif = \DB::table('assessment_programs')->where('status', 'Aktif')->count();

        return [
            Stat::make('Total Karyawan', number_format($totalKaryawan))
                ->description('Karyawan Aktif')
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5]),

            Stat::make('Evaluasi Aktif', $evaluasiAktif . ' Siklus')
                ->description('Program Berjalan')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary')
                ->chart([2, 3, 4, 5, 3, 5, 4]),

            Stat::make('Rata-rata KPI Perusahaan', '84.5 / 100')
                ->description('Bulan Ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info')
                ->chart([60, 70, 75, 80, 82, 84, 84.5]),
        ];
    }
}
