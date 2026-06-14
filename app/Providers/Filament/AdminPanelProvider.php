<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            // Gunakan halaman login custom kita, bukan login bawaan Filament
            ->login(\App\Filament\Auth\Login::class)
            ->brandName('PerformancePro')
            ->colors([
                'primary' => Color::hex('#006240'),
            ])
            ->font('Inter', 'https://fonts.bunny.net/css?family=inter:400,500,600,700')
            ->sidebarWidth('16rem')
            ->navigationItems([
                NavigationItem::make('Dashboard Utama')
                    ->url('/admin')
                    ->icon('heroicon-o-squares-2x2')
                    ->isActiveWhen(fn () => request()->is('admin')),

                NavigationItem::make('Kelola Karyawan')
                    ->url('/admin/employees')
                    ->icon('heroicon-o-users'),

                NavigationItem::make('Formulir Penilaian')
                    ->url('/admin/assessment-forms')
                    ->icon('heroicon-o-document-text'),

                NavigationItem::make('Indikator & Bobot')
                    ->url('/admin/indicators')
                    ->icon('heroicon-o-adjustments-horizontal'),

                NavigationItem::make('Daftar Penilai')
                    ->url('/admin/reviewers')
                    ->icon('heroicon-o-user-group'),

                NavigationItem::make('Dashboard Analisis')
                    ->url('/admin/analysis')
                    ->icon('heroicon-o-chart-bar'),

                NavigationItem::make('Skor Detail')
                    ->url('/admin/results')
                    ->icon('heroicon-o-chart-bar-square'),

                NavigationItem::make('Submit Penilaian')
                    ->url('/admin/submit')
                    ->icon('heroicon-o-paper-airplane'),

                NavigationItem::make('Hasil Penilaian')
                    ->url('/admin/assessment-results')
                    ->icon('heroicon-o-clipboard-document-check'),

                NavigationItem::make('Kelola Akun')
                    ->url('/admin/users')
                    ->icon('heroicon-o-user-circle'),

                NavigationItem::make('Hak Akses')
                    ->url('/admin/roles')
                    ->icon('heroicon-o-shield-check'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
