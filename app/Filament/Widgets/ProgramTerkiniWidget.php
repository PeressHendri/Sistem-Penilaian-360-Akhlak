<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProgramTerkiniWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 2;

    protected static ?string $heading = 'Program Penilaian Terkini';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\AssessmentProgram::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama_program')
                    ->label('Program')
                    ->searchable()
                    ->weight('semibold'),

                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->label('Batas Akhir')
                    ->date('d M Y')
                    ->prefix('Batas Akhir: '),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'Aktif',
                        'warning' => 'Draft',
                        'secondary' => 'Selesai',
                    ])
                    ->formatStateUsing(fn ($state) => match($state) {
                        'Aktif' => 'Berlangsung',
                        'Draft' => 'Persiapan',
                        'Selesai' => 'Selesai',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('progress')
                    ->label('Progress')
                    ->state(function ($record) {
                        return '0%';
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Lihat')
                    ->icon('heroicon-m-eye')
                    ->url(fn ($record) => '/admin/assessment-programs/' . $record->id),
            ])
            ->headerActions([
                Tables\Actions\Action::make('lihat_semua')
                    ->label('Lihat Semua')
                    ->url('/admin/assessment-programs')
                    ->color('primary'),
            ]);
    }
}
