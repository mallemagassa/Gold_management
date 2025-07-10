<?php

namespace App\Resources\Admin;

use App\Models\GoldSale;
use Inertia\Inertia;
use App\Resources\Resource;
use App\Resources\Builders\FormBuilder;
use App\Resources\Builders\TableBuilder;
use App\Resources\Concerns\HasResourceData;
use App\Models\GoldShipment;
use App\Models\User;

class GoldSaleResource extends Resource
{
    use HasResourceData;
    
    protected static string $model = GoldSale::class;
    protected static string $panel = 'admin';
    public static string $label = 'Gold Sale';

    
    public static function shipmentOptions(): array
    {
        return GoldShipment::query()
            ->select(['id', 'name'])
            ->get()
            ->pluck('shipment_code', 'id')
            ->toArray();
    }

    public static function creatorOptions(): array
    {
        return User::query()
            ->select(['id', 'name'])
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }


    public static function index(): \Inertia\Response
    {
        $table = (new TableBuilder(static::$model))
        ->column('shipment.shipment_code', 'Shipment')
        ->column('buyer_name', 'Buyer Name')
        ->column('weight_sold', 'Weight Sold')
        ->column('price_per_gram', 'Price Per Gram')
        ->column('total_price', 'Total Price')
        ->column('currency', 'Currency')
        ->column('sale_date', 'Sale Date')
        ->column('payment_status', 'Payment Status')
        ->column('invoice_number', 'Invoice Number')
        ->column('creator.name', 'Created By')
        ->make();

        return Inertia::render(static::getComponentPath('index'), [
            'table' => $table,
            'resource' => static::getResourceData(),
        ]);
    }

    public static function show($id): \Inertia\Response
    {
        $goldsale = static::$model::with([
            'shipment',
            'creator',
        ])->findOrFail($id);
    
        return Inertia::render(static::getComponentPath('show'), [
            'goldsale' => $goldsale,
            'resource' => static::getResourceData($goldsale),
        ]);
    }
    
    
    public static function create(): \Inertia\Response
    {
        $form = (new FormBuilder())
        ->field('shipment_id', 'select', [
                        'options' => \App\Models\GoldShipment::pluck('shipment_code', 'id'),
                        'required' => true
                    ])
        ->field('buyer_name', 'text', ['required' => true])
        ->field('weight_sold', 'text', ['required' => true])
        ->field('price_per_gram', 'text', ['required' => true])
        ->field('total_price', 'text', ['required' => true])
        ->field('currency', 'text', ['required' => true])
        ->field('sale_date', 'date', ['required' => true])
        ->field('payment_status', 'select', [
            'options' => [
                'pending' => 'pending', 
                'paid' => 'paid',
            ],
            'required' => true,
        ])
        ->field('invoice_number', 'text', ['required' => true])
        // ->field('created_by', 'select', [
        //     'options' => User::pluck('name', 'id'),
        //     'required' => true 
            
        //     ])
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
            'buyer_name' => 'string|required',
            'weight_sold' => 'string|required',
            'price_per_gram' => 'string|required',
            'total_price' => 'string|required',
            'currency' => 'string|required',
            'sale_date' => 'date|required',
            'payment_status' => 'string|required',
            'invoice_number' => 'string|required',
            // 'created_by' => 'integer|required',
            
        ]);

        $data['created_by'] = auth()->user()->id;

        static::$model::create($data);

        return redirect()->route(static::getRouteName('index'));
    }

    public static function edit($id): \Inertia\Response
    {
        $goldsale = static::$model::findOrFail($id);

        $form = (new FormBuilder())
        ->field('shipment_id', 'select', [
                        'options' => \App\Models\GoldShipment::pluck('shipment_code', 'id'),
                        'value' => $goldsale->shipment_id,
                        'required' => true
                    ])
        ->field('buyer_name', 'text', [
                        'required' => true,
                        'value' => $goldsale->buyer_name
                    ])
        ->field('weight_sold', 'text', [
                        'required' => true,
                        'value' => $goldsale->weight_sold
                    ])
        ->field('price_per_gram', 'text', [
                        'required' => true,
                        'value' => $goldsale->price_per_gram
                    ])
        ->field('total_price', 'text', [
                        'required' => true,
                        'value' => $goldsale->total_price
                    ])
        ->field('currency', 'text', [
                        'required' => true,
                        'value' => $goldsale->currency
                    ])
        ->field('sale_date', 'date', [
                        'required' => true,
                        'value' => $goldsale->sale_date
                    ])
        ->field('payment_status', 'select', [
                        'option' => [
                            'prepare' => 'prepare', 
                            'en_transit' => 'en_transit',
                            'livre' => 'livre'
                        ],
                        'required' => true,
                        'value' => $goldsale->payment_status
                    ])
        ->field('invoice_number', 'text', [
                        'required' => true,
                        'value' => $goldsale->invoice_number
                    ])
        // ->field('created_by', 'select', [
        //                 'options' => User::pluck('name', 'id'),
        //                 'required' => true 
                        
        //                 ])
        ->make();

        return Inertia::render(static::getComponentPath('edit'), [
            'goldsale' => $goldsale,
            'form' => $form,
            'resource' => static::getResourceData($goldsale),
        ]);
    }

    public static function update($id): \Illuminate\Http\RedirectResponse
    {
        $goldsale = static::$model::findOrFail($id);
    
        $data = request()->validate([
            'shipment_id' => 'required|exists:gold_shipments,id',
            'buyer_name' => 'string|required',
            'weight_sold' => 'string|required',
            'price_per_gram' => 'string|required',
            'total_price' => 'string|required',
            'currency' => 'string|required',
            'sale_date' => 'date|required',
            'payment_status' => 'string|required',
            'invoice_number' => 'string|required',
            // 'created_by' => 'integer|required',
            
        ]);

        $data['created_by'] = auth()->user()->id;
    
        $goldsale->update($data);
    
        return redirect()->route(static::getRouteName('index'));
    }

    public static function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $goldsale = static::$model::findOrFail($id);
        $goldsale->delete();
        return redirect()->route(static::getRouteName('index'));
    }

    protected static function getComponentPath(string $view): string
    {
        return static::$panel . '/Resources/' . class_basename(static::class) . '/' . $view;
    }
}