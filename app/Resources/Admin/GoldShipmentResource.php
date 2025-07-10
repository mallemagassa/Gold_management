<?php

namespace App\Resources\Admin;

use App\Models\GoldShipment;
use Inertia\Inertia;
use App\Resources\Resource;
use App\Resources\Builders\FormBuilder;
use App\Resources\Builders\TableBuilder;
use App\Resources\Concerns\HasResourceData;
use App\Models\User;
use App\Models\ShipmentItem;
use App\Models\GoldSale;

class GoldShipmentResource extends Resource
{
    use HasResourceData;
    
    protected static string $model = GoldShipment::class;
    protected static string $panel = 'admin';
    public static string $label = 'Gold Shipment';

    
    public static function creatorOptions(): array
    {
        return User::query()
            ->select(['id', 'name'])
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    public static function itemsOptions(): array
    {
        return ShipmentItem::query()
            ->select(['id', 'shipment_id'])
            ->get()
            ->pluck('shipment_id', 'id')
            ->toArray();
    }

    public static function saleOptions(): array
    {
        return GoldSale::query()
            ->select(['id', 'invoice_number'])
            ->get()
            ->pluck('invoice_number', 'id')
            ->toArray();
    }


    public static function index(): \Inertia\Response
    {
        $table = (new TableBuilder(static::$model))
        ->column('shipment_code', 'Shipment Code')
        ->column('total_weight', 'Total Weight')
        ->column('departure_date', 'Departure Date')
        ->column('arrival_date', 'Arrival Date')
        ->column('status', 'Status')
        ->column('tracking_number', 'Tracking Number')
        ->column('carrier_name', 'Carrier Name')
        ->column('creator.name', 'Created By')
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
        ->field('shipment_code', 'text', ['required' => true])
        ->field('total_weight', 'text', ['required' => true])
        ->field('departure_date', 'date', ['required' => true])
        ->field('arrival_date', 'date', ['required' => true])
        ->field('status', 'select', [
            'options' => [
                'prepare' => 'prepare',
                'en_transit' => 'en_transit',
                'livre' => 'livre',
            ],
            'required' => true 
            
            ])
        ->field('tracking_number', 'text', ['required' => true])
        ->field('carrier_name', 'text', ['required' => true])
        ->field('created_by', 'select', [
            'options' => User::pluck('name', 'id'),
            'required' => true 
            
            ])
        // ->field('created_by', 'number', ['required' => true])
        ->make();

        return Inertia::render(static::getComponentPath('create'), [
            'form' => $form,
            'resource' => static::getResourceData(),
        ]);
    }

    public static function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'shipment_code' => 'string|required',
            'total_weight' => 'string|required',
            'departure_date' => 'date|required',
            'arrival_date' => 'date|required',
            'status' => 'string|required',
            'tracking_number' => 'string|required',
            'carrier_name' => 'string|required',
            'created_by' => 'integer|required',
            
        ]);

        static::$model::create($data);

        return redirect()->route(static::getRouteName('index'));
    }

    public static function edit($id): \Inertia\Response
    {
        $goldshipment = static::$model::findOrFail($id);

        $form = (new FormBuilder())
        ->field('shipment_code', 'text', [
                        'required' => true,
                        'value' => $goldshipment->shipment_code
                    ])
        ->field('total_weight', 'text', [
                        'required' => true,
                        'value' => $goldshipment->total_weight
                    ])
        ->field('departure_date', 'date', [
                        'required' => true,
                        'value' => $goldshipment->departure_date
                    ])
        ->field('arrival_date', 'date', [
                        'required' => true,
                        'value' => $goldshipment->arrival_date
                    ])
        ->field('status', 'select', [
                    'options' => [
                        'prepare' => 'prepare',
                        'en_transit' => 'en_transit',
                        'livre' => 'livre',
                    ],
                    'value' => $goldshipment->status,
                    'required' => true 
                    
                    ])
        ->field('tracking_number', 'text', [
                        'required' => true,
                        'value' => $goldshipment->tracking_number
                    ])
        ->field('carrier_name', 'text', [
                        'required' => true,
                        'value' => $goldshipment->carrier_name
                    ])
        ->field('created_by', 'select', [
                        'options' => User::pluck('name', 'id'),
                        'required' => true 
                        
                        ])
        ->make();

        return Inertia::render(static::getComponentPath('edit'), [
            'goldshipment' => $goldshipment,
            'form' => $form,
            'resource' => static::getResourceData($goldshipment),
        ]);
    }

    public static function update($id): \Illuminate\Http\RedirectResponse
    {
        $goldshipment = static::$model::findOrFail($id);
    
        $data = request()->validate([
            'shipment_code' => 'string|required',
            'total_weight' => 'string|required',
            'departure_date' => 'date|required',
            'arrival_date' => 'date|required',
            'status' => 'string|required',
            'tracking_number' => 'string|required',
            'carrier_name' => 'string|required',
            'created_by' => 'integer|required',
            
        ]);
    
        $goldshipment->update($data);
    
        return redirect()->route(static::getRouteName('index'));
    }

    public static function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $goldshipment = static::$model::findOrFail($id);
        $goldshipment->delete();
        return redirect()->route(static::getRouteName('index'));
    }

    protected static function getComponentPath(string $view): string
    {
        return static::$panel . '/Resources/' . class_basename(static::class) . '/' . $view;
    }
}