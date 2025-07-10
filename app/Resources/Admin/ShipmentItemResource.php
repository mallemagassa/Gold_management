<?php

namespace App\Resources\Admin;

use App\Models\ShipmentItem;
use Inertia\Inertia;
use App\Resources\Resource;
use App\Resources\Builders\FormBuilder;
use App\Resources\Builders\TableBuilder;
use App\Resources\Concerns\HasResourceData;
use App\Models\GoldShipment;
use App\Models\GoldInventory;

class ShipmentItemResource extends Resource
{
    use HasResourceData;
    
    protected static string $model = ShipmentItem::class;
    protected static string $panel = 'admin';
    public static string $label = 'Shipment Item';

    
    public static function shipmentOptions(): array
    {
        return GoldShipment::query()
            ->select(['id', 'name'])
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    public static function inventoryOptions(): array
    {
        return GoldInventory::query()
            ->select(['id', 'name'])
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }


    public static function index(): \Inertia\Response
    {
        $table = (new TableBuilder(static::$model))
        ->column('shipment.name', 'Shipment')
        ->column('inventory.name', 'Inventory')
        ->column('weight', 'Weight')
        ->make();

        return Inertia::render(static::getComponentPath('index'), [
            'table' => $table,
            'resource' => static::getResourceData(),
        ]);
    }

    public static function show($id): \Inertia\Response
    {
        $application = static::$model::with(array_keys((new static::$model)->getRelations()))
            ->findOrFail($id);
    
        return Inertia::render(static::getComponentPath('show'), [
            'application' => $application->loadMissing(array_keys($application->getRelations())),
            'resource' => static::getResourceData($application),
        ]);
    }
    
    public static function create(): \Inertia\Response
    {
        $form = (new FormBuilder())
        ->field('shipment_id', 'select', [
                        'options' => \App\Models\GoldShipment::pluck('name', 'id'),
                        'required' => true
                    ])
        ->field('inventory_id', 'select', [
                        'options' => \App\Models\GoldInventory::pluck('name', 'id'),
                        'required' => true
                    ])
        ->field('weight', 'text', ['required' => true])
        ->make();

        return Inertia::render(static::getComponentPath('create'), [
            'form' => $form,
            'resource' => static::getResourceData(),
        ]);
    }

    public static function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'shipment_id' => 'required|exists:gold_shipments,id',
            'inventory_id' => 'required|exists:gold_inventories,id',
            'weight' => 'string|required',
            
        ]);

        static::$model::create($data);

        return redirect()->route(static::getRouteName('index'));
    }

    public static function edit($id): \Inertia\Response
    {
        $shipmentitem = static::$model::findOrFail($id);

        $form = (new FormBuilder())
        ->field('shipment_id', 'select', [
                        'options' => \App\Models\GoldShipment::pluck('name', 'id'),
                        'value' => $shipmentitem->shipment_id,
                        'required' => true
                    ])
        ->field('inventory_id', 'select', [
                        'options' => \App\Models\GoldInventory::pluck('name', 'id'),
                        'value' => $shipmentitem->inventory_id,
                        'required' => true
                    ])
        ->field('weight', 'text', [
                        'required' => true,
                        'value' => $shipmentitem->weight
                    ])
        ->make();

        return Inertia::render(static::getComponentPath('edit'), [
            'shipmentitem' => $shipmentitem,
            'form' => $form,
            'resource' => static::getResourceData($shipmentitem),
        ]);
    }

    public static function update($id): \Illuminate\Http\RedirectResponse
    {
        $shipmentitem = static::$model::findOrFail($id);
    
        $data = request()->validate([
            'shipment_id' => 'required|exists:gold_shipments,id',
            'inventory_id' => 'required|exists:gold_inventories,id',
            'weight' => 'string|required',
            
        ]);
    
        $shipmentitem->update($data);
    
        return redirect()->route(static::getRouteName('index'));
    }

    public static function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $shipmentitem = static::$model::findOrFail($id);
        $shipmentitem->delete();
        return redirect()->route(static::getRouteName('index'));
    }

    protected static function getComponentPath(string $view): string
    {
        return static::$panel . '/Resources/' . class_basename(static::class) . '/' . $view;
    }
}