<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Resources\Admin\RoleResource;
use Spatie\Permission\Models\Permission;
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

class GenerateResourcePermissions extends Command
{
    protected $signature = 'permissions:generate';
    protected $description = 'Generate permissions for all resources';

    public function handle()
    {
        $resources = [
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
            RoleResource::class,
            BaremeDesignationCaratResource::class,
            FonteGoldResource::class
        ];

        $actions = ['viewAny', 'view', 'create', 'update', 'delete', 'restore', 'forceDelete'];

        foreach ($resources as $resource) {
            $modelName = Str::snake(class_basename($resource));
            
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$action} {$modelName}",
                    'guard_name' => 'web',
                ]);
                
                $this->info("Created permission: {$action} {$modelName}");
            }
        }

        $this->info('All permissions generated successfully!');
    }
}