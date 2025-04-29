<?php

namespace Sharenjoy\NoahCms;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Outerweb\FilamentSettings\Filament\Plugins\FilamentSettingsPlugin;
use Outerweb\FilamentTranslatableFields\Filament\Plugins\FilamentTranslatableFieldsPlugin;
use RalphJSmit\Filament\Activitylog\FilamentActivitylog;
use RalphJSmit\Filament\MediaLibrary\FilamentMediaLibrary;
use Sharenjoy\NoahCms\Pages\MediaLibrary;
use Sharenjoy\NoahCms\Pages\Settings\Settings;

class NoahPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('noah')
            ->path('noah')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->viteTheme('resources/css/filament/noah/theme.css')
            ->sidebarCollapsibleOnDesktop()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
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
            ])
            ->plugins([
                NoahCmsPlugin::make(),
                FilamentShieldPlugin::make(),
                SpatieLaravelTranslatablePlugin::make()->defaultLocales(array_keys(config('noah-cms.locale'))),
                FilamentTranslatableFieldsPlugin::make()->supportedLocales(config('noah-cms.locale')),
                FilamentSettingsPlugin::make()->pages([
                    Settings::class,
                ]),
                FilamentActivitylog::make(),
                FilamentMediaLibrary::make()
                    ->navigationLabel($this->mediaLibraryLabel())
                    ->pageTitle($this->mediaLibraryLabel())
                    ->slug('media-browser')
                    ->acceptPdf()
                    ->acceptVideo()
                    ->showUploadBoxByDefault()
                    ->mediaPickerModalWidth('7xl')
                    ->unstoredUploadsWarning()
                    ->mediaInfoOnMultipleSelection()
                    ->registerPages([
                        MediaLibrary::class,
                    ]),
            ]);
    }

    protected function mediaLibraryLabel(): string
    {
        return match (app()->currentLocale()) {
            'zh_TW' => '媒體庫',
            'en' => 'Media Library',
            default => 'Media Library',
        };
    }
}
