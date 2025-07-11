<?php

namespace App\Providers;

use App\Models\LocalRate;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use App\Resources\Admin\RoleResource;
use App\Providers\PanelServiceProvider;
use Illuminate\Support\ServiceProvider;
use App\Resources\Admin\GoldSaleResource;
use App\Resources\Admin\SupplierResource;
use App\Resources\Admin\FonteGoldResource;
use App\Resources\Admin\LocalRateResource;
use App\Resources\Admin\TransactionResource;
use App\Resources\Admin\ExchangeRateResource;
use App\Resources\Admin\GoldShipmentResource;
use App\Resources\Admin\ShipmentItemResource;
use App\Resources\Admin\GoldInventoryResource;
use App\Resources\Admin\RefiningBatcheResource;
use App\Resources\Admin\GoldMarketPriceResource;
use App\Resources\Admin\LocalGoldPurchaseResource;
use App\Resources\Admin\BaremeDesignationCaratResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(PanelServiceProvider::class);

        // PanelServiceProvider::registerCustomLinks([
        //     'admin' => [
        //         [
        //             'label' => 'Applications approuvées',
        //             'name' => 'ApplicationsApprouves',
        //             'routeName' => 'applications.approved',
        //             'group' => 'Évaluation',
        //             'path' => 'applications/approved',
        //             'icon' => 'CheckCircle',
        //         ],
        //     ]
        // ]);
    
        PanelServiceProvider::registerPanels([
            'admin' => [
                'path' => 'admin',
                'middleware' => ['web', 'auth'],
                'layout' => 'AppLayout',
                'resources' => [
                    ExchangeRateResource::class,
                    GoldInventoryResource::class,
                    GoldMarketPriceResource::class,
                    GoldSaleResource::class,
                    GoldShipmentResource::class,
                    LocalGoldPurchaseResource::class,
                    LocalRateResource::class,
                    RefiningBatcheResource::class,
                    ShipmentItemResource::class,
                    SupplierResource::class,
                    TransactionResource::class,
                    BaremeDesignationCaratResource::class,
                    RoleResource::class,
                    FonteGoldResource::class

                ]
            ]
        ]);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
        
        Inertia::share([
           'localRate' => function() {
                $latest = LocalRate::latest()->first();
                return $latest ? ['id' => $latest->id, 'rate_per_gram' => $latest->rate_per_gram] : ['rate_per_gram' => 0];
            },
            'resources' => function () {
                $panel = PanelServiceProvider::getActivePanel();
                $config = PanelServiceProvider::getPanelConfig($panel);
        
                if (! $config || ! isset($config['resources'])) {
                    return [];
                }
        
                $grouped = [];
        
                // Regrouper les resources normales
                foreach ($config['resources'] as $resource) {
                    $group = $resource::$group ?? null;
        
                    $item = [
                        'name' => class_basename($resource),
                        'routeName' => Str::kebab(class_basename($resource)),
                        'label' => $resource::$label ?? Str::title(Str::snake(class_basename($resource), ' ')),
                    ];
        
                    if ($group) {
                        $grouped[$group][] = $item;
                    } else {
                        $grouped[] = $item;
                    }
                }
        
                // Ajouter les liens personnalisés
                $customLinks = PanelServiceProvider::getCustomLinks($panel);
        
                foreach ($customLinks as $link) {
                    $grouped[$link['group']][] = [
                        'name' => Str::slug($link['label']),
                        'routeName' => $link['path'],
                        'label' => $link['label'],
                        'icon' => $link['icon'] ?? 'Folder',
                        'is_custom' => true,
                    ];
                }
        
                return $grouped;
            },
        ]);
    }
}
