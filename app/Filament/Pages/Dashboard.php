<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Dashboard Utama';

    protected static ?string $title = 'Dashboard Utama';

    protected static ?int $navigationSort = 1;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('buat_evaluasi')
                ->label('+ Buat Evaluasi Baru')
                ->url('/admin/assessment-programs/create')
                ->color('primary')
                ->size('md'),
        ];
    }

    public function getColumns(): int | string | array
    {
        return 3;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsOverviewWidget::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\ProgramTerkiniWidget::class,
            \App\Filament\Widgets\AksiCepatWidget::class,
        ];
    }
}
