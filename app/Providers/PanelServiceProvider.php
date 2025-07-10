<?php

// app/Providers/PanelServiceProvider.php
namespace App\Providers;

use Inertia\Inertia;
use App\Models\GoldSale;
use App\Models\Application;
use Illuminate\Support\Str;
use App\Models\LocalGoldPurchase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\EnsurePanelAccess;
use App\Resources\Admin\ApplicationResource;

class PanelServiceProvider extends ServiceProvider
{
    protected static array $panels = [];

    public static string $defaultPanel = 'admin';

    protected static array $customLinks = [];

    public static function registerCustomLinks(array $links): void
    {
        static::$customLinks = array_merge(static::$customLinks, $links);
    }

    public static function getCustomLinks(string $panel): array
    {
        return static::$customLinks[$panel] ?? [];
    }

    public static function registerPanels(array $panels): void
    {
        static::$panels = array_merge(static::$panels, $panels);
    }

    public static function getPanelConfig(string $panel): ?array
    {
        return static::$panels[$panel] ?? null;
    }

    public static function getDefaultPanel(): string
    {
        return static::$defaultPanel;
    }

    public function boot(): void
    {
        foreach (static::$panels as $panel => $config) {
            $this->registerPanelRoutes($panel, $config);
        }
    }

    protected function registerPanelRoutes(string $panel, array $config): void
    {
        Route::prefix($config['path'])
            ->middleware(array_merge($config['middleware']))
            ->name("{$panel}.")
            ->group(function () use ($panel, $config) {
                    $recentSales = GoldSale::with(['creator'])
                        ->orderBy('sale_date', 'desc')
                        ->take(5)
                        ->get();

                    $recentPurchasesLocal = LocalGoldPurchase::with(['supplier'])
                        ->orderBy('purchase_date', 'desc')
                        ->take(5)
                        ->get();

                    Route::get('/', function () use ($recentSales, $recentPurchasesLocal) {
                        return Inertia::render("Dashboard", compact('recentSales', 'recentPurchasesLocal'));
                    })->name('dashboard');
                    
                
                foreach ($config['resources'] as $resource) {
                    $this->registerResourceRoutes($resource, $panel);
                }

                foreach (PanelServiceProvider::getCustomLinks($panel) as $link) {
                    // Route::get($link['path'], [ApplicationResource::class, 'showCustomPage'])
                    //     ->defaults('panel', $panel)
                    //     ->defaults('page', $link['name'])
                    //     ->name("{$panel}." . $link['routeName'])
                    //     ->middleware(array_merge($config['middleware'], [EnsurePanelAccess::class], ['verified']));
                }
                
            });
    }

    protected function registerResourceRoutes(string $resource, string $panel): void
    {
        $baseName = Str::kebab(class_basename($resource));
        $permissionName = Str::snake(class_basename($resource));
        Route::prefix($baseName)
            ->name("{$baseName}.")
            ->middleware(['can:viewAny '.$permissionName])
            ->group(function () use ($resource, $permissionName) {
                Route::get('/', [$resource, 'index'])->name('index');
                Route::get('/create', [$resource, 'create'])->middleware("can:create {$permissionName}")->name('create');
                Route::post('/', [$resource, 'store'])->middleware("can:create {$permissionName}")->name('store');
                Route::get('/{id}', [$resource, 'show'])->middleware("can:view {$permissionName}")->name('show');
                Route::get('/edit/{id}', [$resource, 'edit'])->middleware("can:update {$permissionName}")->name('edit');
                Route::put('/{id}', [$resource, 'update'])->middleware("can:update {$permissionName}")->name('update');
                Route::delete('/{id}', [$resource, 'destroy'])->middleware("can:delete {$permissionName}")->name('destroy');
            });
    }

    protected function getResourcesForPanel(string $panel): array
    {
        $resources = [];
        $resourcePath = app_path("Resources/{$panel}");

        if (file_exists($resourcePath)) {
            foreach (scandir($resourcePath) as $file) {
                if (str_ends_with($file, 'Resource.php')) {
                    $resources[] = "App\\Resources\\{$panel}\\" . str_replace('.php', '', $file);
                }
            }
        }

        return $resources;
    }

    public static function getActivePanel(): ?string
    {
        $route = Route::current();

        if (! $route) return null;

        $routeName = $route->getName();

        if (! $routeName) return null;

        return explode('.', $routeName)[0];
    }


}
