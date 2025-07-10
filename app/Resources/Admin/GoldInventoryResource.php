<?php

namespace App\Resources\Admin;

use App\Models\GoldInventory;
use Inertia\Inertia;
use App\Resources\Resource;
use App\Resources\Builders\FormBuilder;
use App\Resources\Builders\TableBuilder;
use App\Resources\Concerns\HasResourceData;
use App\Models\RefiningBatche;
use App\Models\ShipmentItem;

class GoldInventoryResource extends Resource
{
    use HasResourceData;
    
    protected static string $model = GoldInventory::class;
    protected static string $panel = 'admin';
    public static string $label = 'Gold Inventory';

    
    public static function batchOptions(): array
    {
        return RefiningBatche::query()
            ->select(['id', 'batch_code'])
            ->get()
            ->pluck('batch_code', 'id')
            ->toArray();
    }

    public static function shipmentItemsOptions(): array
    {
        return ShipmentItem::query()
            ->select(['id', 'name'])
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }


    public static function index(): \Inertia\Response
    {
        $table = (new TableBuilder(static::$model))
        ->column('batch.batch_code', 'Refining Batch Id')
        ->column('weight_available', 'Weight Available')
        ->column('location', 'Location')
        ->column('status', 'Status')
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
        ->field('refining_batch_id', 'select', [
            'options' => RefiningBatche::pluck('batch_code', 'id'),
            'required' => true,
        ])
        ->field('weight_available', 'text', ['required' => true])
        ->field('location', 'text', ['required' => true])
        ->field('status', 'select', [
            'options' => [
                'en_stock' => 'en_stock', 
                'reserve' => 'reserve',
                'en_transit' => 'en_transit',
                'vendu' => 'vendu',
            ],
            'required' => true,
        ])
        ->make();

        return Inertia::render(static::getComponentPath('create'), [
            'form' => $form,
            'resource' => static::getResourceData(),
        ]);
    }

    public static function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'refining_batch_id' => 'string|required',
            'weight_available' => 'string|required',
            'location' => 'string|required',
            'status' => 'string|required',
            
        ]);

        static::$model::create($data);

        return redirect()->route(static::getRouteName('index'));
    }

    public static function edit($id): \Inertia\Response
    {
        $goldinventory = static::$model::findOrFail($id);

        $form = (new FormBuilder())
        ->field('refining_batch_id', 'select', [
            'options' => RefiningBatche::pluck('batch_code', 'id'),
            'required' => true,
        ])
        ->field('weight_available', 'text', [
                        'required' => true,
                        'value' => $goldinventory->weight_available
                    ])
        ->field('location', 'text', [
                        'required' => true,
                        'value' => $goldinventory->location
                    ])
        ->field('status', 'select', [
                        'options' => [
                            'en_stock' => 'en_stock', 
                            'reserve' => 'reserve',
                            'en_transit' => 'en_transit',
                            'vendu' => 'vendu',
                        ],
                        'required' => true,
                        'value' => $goldinventory->status
                    ])
        ->make();

        return Inertia::render(static::getComponentPath('edit'), [
            'goldinventory' => $goldinventory,
            'form' => $form,
            'resource' => static::getResourceData($goldinventory),
        ]);
    }

    public static function update($id): \Illuminate\Http\RedirectResponse
    {
        $goldinventory = static::$model::findOrFail($id);
    
        $data = request()->validate([
            'refining_batch_id' => 'string|required',
            'weight_available' => 'string|required',
            'location' => 'string|required',
            'status' => 'string|required',
            
        ]);
    
        $goldinventory->update($data);
    
        return redirect()->route(static::getRouteName('index'));
    }

    public static function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $goldinventory = static::$model::findOrFail($id);
        $goldinventory->delete();
        return redirect()->route(static::getRouteName('index'));
    }

    protected static function getComponentPath(string $view): string
    {
        return static::$panel . '/Resources/' . class_basename(static::class) . '/' . $view;
    }
}